<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Http\Requests\StockMovementRequest;
use App\Services\StockMovementService;
use Illuminate\Http\Request;

class StockMovementController
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(private StockMovementService $stockMovementService) {}
    public function index(Request $request)
    {
        $search = $request->query('search');
        $type = $request->query('type');
        $stockMovements = $this->stockMovementService->getAll($search, $type);

        return view('pages.admin.stock_movement.index', compact('stockMovements', 'search', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockMovementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMovement $stockMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockMovement $stockMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockMovementRequest $request, StockMovement $stockMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMovement $stockMovement)
    {
        //
    }
}
