<?php

namespace App\Services;

use App\Models\Part;
use Illuminate\Support\Facades\DB;

class PartService
{
    /**
     * Get all parts with optional search filter and pagination.
     */

    public function __construct(private StockMovementService $StockMovementService)
    {}
    public function getAll(?string $search = null, int $perPage = 10)
    {
        return Part::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('updated_at')
            ->paginate($perPage);
    }

    /**
     * Create a new part.
     */
    public function create(array $data): Part
    {
        DB::beginTransaction();
        try {
            $part = Part::query()->create($data);
            DB::commit();

            return $part;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing part.
     */
    public function update(Part $part, array $data): bool
    {
        DB::beginTransaction();
        try {
            $result = $part->update($data);
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a part.
     */
    public function delete(Part $part): ?bool
    {
        return $part->delete();
    }

    /**
     * Add stock to a part.
     */
    public function addStock(Part $part, array $data): bool
    {

        DB::beginTransaction();
        try {
            $part->increment('stock', $data['quantity']);
            $this->StockMovementService->recordStockMovement($data['dataStockMovement']);
            
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reduce stock from a part.
     */
    public function reduceStock(Part $part, array $data): bool
    {
       

        DB::beginTransaction();
        try {
            $part->decrement('stock', $data['quantity']);
            $this->StockMovementService->recordStockMovement($data['dataStockMovement']);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}