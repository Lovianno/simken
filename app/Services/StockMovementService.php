<?php

namespace App\Services;

use App\Models\StockMovement;

class StockMovementService
{
    /**
     * Get all stock movements with optional search and type filter and pagination.
     */
    public function getAll(?string $search = null, ?string $type = null, int $perPage = 10)
    {
        $query = StockMovement::query()->with('part', 'user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRelation('part', 'name', 'like', "%{$search}%")
                    ->orWhereRelation('user', 'name', 'like', "%{$search}%");
            });
        }

        if ($type && in_array($type, ['in', 'out'])) {
            $query->where('type', $type);
        }

        return $query->orderByDesc('created_at')->paginate($perPage);
    }
    public function recordStockMovement(array $data)
    {
            $stockMovement = StockMovement::query()->create($data);
            return $stockMovement;
          
    }
}
