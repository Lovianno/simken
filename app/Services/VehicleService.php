<?php

namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class VehicleService
{
    /**
     * Get all vehicles with optional search filter and pagination.
     */
    public function getAll(?string $search = null, int $perPage = 10)
    {
        return Vehicle::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nopol', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhere('unit_number', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('updated_at')
            ->paginate($perPage);
    }

    /**
     * Create a new vehicle.
     */
    public function create(array $data): Vehicle
    {
        DB::beginTransaction();
        try {
            $vehicle = Vehicle::query()->create($data);
            DB::commit();

            return $vehicle;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing vehicle.
     */
    public function update(Vehicle $vehicle, array $data): bool
    {
        DB::beginTransaction();
        try {
            $result = $vehicle->update($data);
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a vehicle.
     */
    public function delete(Vehicle $vehicle): ?bool
    {
        return $vehicle->delete();
    }
}