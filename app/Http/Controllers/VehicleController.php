<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Http\Requests\VehicleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        // All vehicles
        $vehicles = Vehicle::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nopol', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhere('unit_number', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('updated_at')
            ->paginate(10);

        $currentPage = $vehicles->currentPage();
        $lastPage = $vehicles->lastPage();
        $perPage = $vehicles->perPage();
        $total = $vehicles->total();

        return view('pages.admin.vehicle.index', compact(
            'vehicles',
            'search',
            'currentPage',
            'lastPage',
            'perPage',
            'total'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
                return view('pages.admin.vehicle.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {

            $vehicle = Vehicle::query()->create($data);

            DB::commit();
            return redirect()->route('vehicles.index')->with('success', 'Data Kendaraan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menambah kendaraan. Silakan coba lagi.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
                return view('pages.admin.vehicle.show', compact('vehicle'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('pages.admin.vehicle.edit', compact('vehicle'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
          $data = $request->validated();

        DB::beginTransaction();
        try {
          
            $vehicle->update($data);

            DB::commit();
            return redirect()->route('vehicles.index')->with('success', 'Data Kendaraan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui kendaraan. Silakan coba lagi.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Data Kendaraan berhasil dihapus.');
    }
}
