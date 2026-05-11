<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportIssue;
use App\Models\ReportItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Get all reports with optional search filter and pagination.
     */

    public function __construct(private PartService $partService) {}
    public function getAll(?string $search = null, int $perPage = 10)
    {
        $query = Report::query()->with('user', 'vehicle');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRelation('user', 'name', 'like', "%{$search}%");
                $q->orWhereRelation('vehicle', 'nopol', 'like', "%{$search}%");
            });
        }

        return $query->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function getReport(Report $report): Report
    {
        return $report->load('user', 'vehicle', 'reportIssue.reportItem.part');
    }

    public function getVehicleReportHistory(int $vehicleId, int $perPage = 10)
    {
        return Report::where('vehicle_id', $vehicleId)->where('status', 'active')
            ->with('user', 'reportIssue.reportItem.part')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }
    /**
     * Create a new report.
     */
    public function create(array $data)
    {
        DB::transaction(function () use ($data) {

            // ── OPTIMASI: Hitung kebutuhan stok tiap part dulu (1 pass) ──
            $partStock = [];
            foreach ($data['issues'] as $issue) {
                foreach ($issue['items'] as $item) {
                    $partId = $item['part_id'];
                    $partStock[$partId] = ($partStock[$partId] ?? 0) + (int) $item['quantity'];
                }
            }

            // ── OPTIMASI: Sort by key agar urutan lock konsisten → cegah deadlock ──
            ksort($partStock);

            // ── OPTIMASI: Lock semua part sekaligus + cek stok + simpan ke array ──
            $lockedParts = [];
            foreach ($partStock as $partId => $totalQty) {
                $part = $this->partService->getPartByIdWithLock($partId);
                if ($totalQty > $part->stock) {
                    throw new \Exception(
                        "Stok part {$part->name} tidak mencukupi. Dibutuhkan {$totalQty}, tersedia {$part->stock}"
                    );
                }
                $lockedParts[$partId] = $part; // simpan instance yang sudah di-lock
            }

            // ── OPTIMASI: Hitung grand total & siapkan data pakai $lockedParts
            //             (tidak query lagi ke DB, sudah di memory) ──
            $grandTotal   = 0;
            $reportIssues = [];
            foreach ($data['issues'] as $issue) {
                $issueData = [
                    'issue_description' => $issue['issue_description'],
                    'items'             => [],
                ];

                foreach ($issue['items'] as $item) {
                    $part       = $lockedParts[$item['part_id']]; // OPTIMASI: reuse dari memory
                    $qty        = (int) $item['quantity'];
                    $unitPrice  = $part->base_price;
                    $totalPrice = $unitPrice * $qty;
                    $grandTotal += $totalPrice;

                    $issueData['items'][] = [
                        'part_id'     => $item['part_id'],
                        'quantity'    => $qty,
                        'unit_price'  => $unitPrice,
                        'total_price' => $totalPrice,
                    ];
                }

                $reportIssues[] = $issueData;
            }

            // Query Create Report
            $report = Report::create([
                'vehicle_id'  => $data['vehicle_id'],
                'user_id'     => Auth::id(),
                'date'        => $data['date'],
                'grand_total' => $grandTotal,
            ]);

            // Query Create ReportIssue + ReportItem + Kurangi Stok
            foreach ($reportIssues as $issue) {
                $reportIssue = ReportIssue::create([
                    'report_id'         => $report->id,
                    'issue_description' => $issue['issue_description'],
                ]);

                foreach ($issue['items'] as $item) {
                    ReportItem::create([
                        'report_issue_id' => $reportIssue->id,
                        'part_id'         => $item['part_id'],
                        'quantity'        => $item['quantity'],
                        'unit_price'      => $item['unit_price'],
                        'total_price'     => $item['total_price'],
                    ]);

                    // ── OPTIMASI: Reuse $lockedParts, tidak getPartByIdWithLock lagi ──
                    $part = $lockedParts[$item['part_id']];
                    $this->partService->reduceStock(
                        $part,
                        $item['quantity'],
                        "Penggunaan suku cadang untuk laporan #{$report->id}",
                        useTransaction: false // sudah dalam parent transaction
                    );
                }
            }
        });
    }

    /**
     * Update an existing report.
     */

    public function cancel(Report $report)
    {
        // ── MINOR 1: Load relasi di luar transaction (hanya baca) ──
        $report->load('reportIssue.reportItem');

        DB::transaction(function () use ($report) {

            // ── BUG FIX: Lock report dulu sebelum cek status ──
            $report = Report::lockForUpdate()->findOrFail($report->id);
            if ($report->status === 'cancelled') {
                throw new \Exception("Report sudah dibatalkan.");
            }

            // Kumpulkan semua part_id & sort agar lock konsisten
            $partIds = [];
            foreach ($report->reportIssue as $issue) {
                foreach ($issue->reportItem as $item) {
                    $partIds[] = $item->part_id;
                }
            }
            $partIds = array_unique($partIds);
            sort($partIds); // cegah deadlock

            // Lock semua part sekaligus
            $lockedParts = [];
            foreach ($partIds as $partId) {
                $lockedParts[$partId] = $this->partService->getPartByIdWithLock($partId);
            }

            // Return stok pakai locked parts
            foreach ($report->reportIssue as $issue) {
                foreach ($issue->reportItem as $item) {
                    $part = $lockedParts[$item->part_id];
                    $this->partService->addStock(
                        $part,
                        $item->quantity,
                        "Pembatalan laporan #{$report->id}",
                        useTransaction: false
                    );
                }
            }

            // ── MINOR 2: Update status eksplisit ──
            $report->update(['status' => 'cancelled']);
        });
    }

    /**
     * Delete a report.
     */
    public function changeStatus(Report $report)
    {
        $report->status = "cancelled";
        $report->save();
    }

    public function delete(Report $report): ?bool
    {
        return $report->delete();
    }
}
