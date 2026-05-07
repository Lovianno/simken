<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\ReportRequest;

use App\Services\PartService;
use App\Services\ReportService;
use App\Services\VehicleService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private ReportService $reportService, private VehicleService $vehicleService, private PartService $partService) {}
    public function index(Request $request)
    {
        $search = $request->query('search');
        $reports = $this->reportService->getAll($search);

        return view('pages.admin.report.index', compact('reports', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = $this->vehicleService->getVehicleOptions();
        $parts    = $this->partService->getPartOptions();
        return view('pages.admin.report.create', compact('vehicles', 'parts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportRequest $request)
    {
        $data = $request->validated();
        try {

            $this->reportService->create($data);

            return redirect()->route('reports.index')
                ->with('success', 'Laporan berhasil dibuat.');
        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Stok suku cadang tidak mencukupi!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        // return $this->partService->getPartById($report->id);
        $report = $this->reportService->getReport($report);
        return view('pages.admin.report.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        $report = $this->reportService->getReport($report);

        return view('pages.admin.report.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Report $report)
    {
        $this->reportService->cancel($report);
        return redirect()->route('reports.index', $report)->with('success', 'Laporan berhasil dibatalkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $this->reportService->delete($report);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
    public function print(Report $report)
    {
        if($report->status === 'cancelled') {
            return redirect()->back()->with('error', 'Laporan sudah dibatalkan, tidak dapat dicetak.');
        }

        $report = $this->reportService->getReport($report);

        $pdf = Pdf::loadView('reports.repairpdf', compact('report'))
            ->setPaper('a4', 'portrait');

        $filename = 'Laporan-' . $report->vehicle->nopol  . '.pdf';

        return $pdf->stream($filename);
    }
}
