<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Http\Requests\VehicleRequest;
use App\Services\VehicleService;
use Illuminate\Http\Request;

class VehicleController
{
    public function __construct(private VehicleService $vehicleService) { }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $vehicles = $this->vehicleService->getAll($search);

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
        try {
            $this->vehicleService->create($request->validated());
            return redirect()->route('vehicles.index')->with('success', 'Data Kendaraan berhasil ditambahkan.');
        } catch (\Exception $e) {
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
        try {
            $this->vehicleService->update($vehicle, $request->validated());
            return redirect()->route('vehicles.index')->with('success', 'Data Kendaraan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui kendaraan. Silakan coba lagi.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $this->vehicleService->delete($vehicle);
        return redirect()->route('vehicles.index')->with('success', 'Data Kendaraan berhasil dihapus.');
    }
}
