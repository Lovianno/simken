<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Get all reports with optional search filter and pagination.
     */
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
    public function create(array $data): Report
    {
        DB::beginTransaction();
        try {
            $report = Report::query()->create($data);
            DB::commit();

            return $report;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing report.
     */
    public function update(Report $report, array $data): bool
    {
        DB::beginTransaction();
        try {
            $result = $report->update($data);
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a report.
     */
    public function delete(Report $report): ?bool
    {
        return $report->delete();
    }
}
