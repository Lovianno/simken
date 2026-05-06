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
    /**
     * Create a new report.
     */
    public function create(array $data)
    {
        DB::transaction(function () use ($data) {

            // Variabel Penampung Sementara
            $reportIssues = [];
            $partStock = [];
            $grandTotal = 0;

            // Persiapan Data untuk Create Report, ReportIssue, dan ReportItem
            foreach ($data['issues'] as $issue) {
                $issueData = [
                    'issue_description' => $issue['issue_description'],
                    'items' => []
                ];

                foreach ($issue['items'] as $item) {
                    $partId = $item['part_id'];
                    $part = $this->partService->getPartById($partId);

                    $unitPrice = $part->base_price;
                    $qty = (int) $item['quantity'];
                    $totalPrice = $unitPrice * $qty;

                    $partStock[$partId] = ($partStock[$partId] ?? 0) + $qty;
                    $grandTotal += $totalPrice;

                    $issueData['items'][] = [
                        'part_id' => $item['part_id'],
                        'quantity' => $qty,
                        'unit_price' => $unitPrice,
                        'total_price' => $totalPrice,
                    ];
                }
                $reportIssues[] = $issueData;
            }

            // Pengecekan Stok tiap Part Mencukupi atau tidak
            foreach ($partStock as $partId => $totalQty) {
                $part = $this->partService->getPartById($partId);
                if ($totalQty > $part->stock) {
                    throw new \Exception("Stok part {$part->name} tidak mencukupi. Dibutuhkan {$totalQty}, tersedia {$part->stock}");
                }
            }


            // Query Create Report, ReportIssue, dan ReportItem
            $report = Report::create([
                'vehicle_id' => $data['vehicle_id'],
                'user_id' => Auth::id(),
                'date' => $data['date'],
                'grand_total' => $grandTotal,
            ]);

            foreach ($reportIssues as $issue) {

                $reportIssue = ReportIssue::create([
                    'report_id' => $report->id,
                    'issue_description' => $issue['issue_description']
                ]);

                foreach ($issue['items'] as $item) {
                    ReportItem::create([
                        'report_issue_id' => $reportIssue->id,
                        'part_id' => $item['part_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['total_price'],
                    ]);

                    // Update Stock Part
                    $part = $this->partService->getPartById($item['part_id']);
                    $this->partService->reduceStock($part, $item['quantity'], "Penggunaan suku cadang");
                }
            }
        });
    }

    /**
     * Update an existing report.
     */

    public function cancel(Report $report)
    {
        DB::transaction(function () use ($report) {

            // ❗ Hindari cancel berulang
            if ($report->status === 'cancelled') {
                throw new \Exception("Report sudah dibatalkan.");
            }
           
          $report->load('reportIssue.reportItem.part');
            foreach ($report->reportIssue as $issue) {
                foreach ($issue->reportItem as $item) {

                    // 🔒 lock biar aman dari race condition
                    $part = $item->part()->lockForUpdate()->first();

                    // 🔁 kembalikan stok
                   $this->partService->addStock($part, $item->quantity, "Pembatalan laporan #{$report->id}");
                    
                }
            }

            // Change status report jadi cancelled
            $this->changeStatus($report);
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
