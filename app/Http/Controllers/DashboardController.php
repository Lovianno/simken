<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Report;
use App\Models\StockMovement;
use App\Models\Vehicle;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_vehicles'   => Vehicle::count(),
            'total_reports'    => Report::where('status', 'active')->count(),
            'monthly_reports'  => Report::where('status', 'active')->whereMonth('date', now()->month)->count(),
            'monthly_cost'     => Report::where('status', 'active')->whereMonth('date', now()->month)->sum('grand_total'),

            'total_parts'      => Part::count(),
            'low_stock_parts'  => Part::where('stock', '<=', 5)->count(),
            'stock_in_count'   => StockMovement::where('type', 'in')->whereMonth('created_at', now()->month)->count(),
            'stock_out_count'  => StockMovement::where('type', 'out')->whereMonth('created_at', now()->month)->count(),
        ];

        $recentReports = Report::with(['vehicle', 'user'])
            ->latest('date')
            ->limit(5)
            ->get();

        $lowStockParts = Part::where('stock', '<=', 10)
            ->orderBy('stock')
            ->limit(6)
            ->get();

        return view('pages.admin.dashboard', compact('stats', 'recentReports', 'lowStockParts'));
    }
}
