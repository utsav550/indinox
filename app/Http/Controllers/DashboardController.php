<?php

namespace App\Http\Controllers;

use App\Models\Load;


class DashboardController extends Controller
{
    public function index()
    {
        
        $totalLoads = Load::count();
        $deliveredLoads = Load::where('status', 'delivered')->count();
        $pendingLoads = Load::where('status', 'pending')->count();
        $totalRevenue = Load::sum('price');
        $totalExpense = Load::sum('expense');
        $totalProfit = Load::sum('price') - $totalExpense;
        $driverProfits = \App\Models\Load::with('driver')
    ->get()
    ->groupBy('driver_id')
    ->map(function ($loads) {
        $totalRevenue = $loads->sum('price');
        $totalExpense = $loads->sum('expense');
        return [
            'driver' => $loads->first()->driver->name ?? 'Unknown',
            'profit' => $totalRevenue - $totalExpense,
        ];
    });
        return view('dashboard', compact(
            'totalLoads',
            'deliveredLoads',
            'pendingLoads',
            'totalRevenue',
            'totalExpense',
            'totalProfit',
            'driverProfits'
        ));
    }
}