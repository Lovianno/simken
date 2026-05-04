<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\ReportRequest;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController
{
    /**
     * Display a listing of the resource.
     */
     public function __construct(private ReportService $reportService) {}
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
        return view('pages.admin.report.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportRequest $request)
    {
        $this->reportService->create($request->validated());

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
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
    public function update(ReportRequest $request, Report $report)
    {
        $this->reportService->update($report, $request->validated());

        return redirect()->route('reports.show', $report)->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $this->reportService->delete($report);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
