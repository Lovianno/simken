<?php

namespace App\Services;

use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class StockMovementService
{
    /**
     * Get all parts with optional search filter and pagination.
     */
   
    public function recordStockMovement(array $data){
        DB::beginTransaction();
        try {
            $stockMovement = StockMovement::query()->create($data);
            DB::commit();

            return $stockMovement;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}