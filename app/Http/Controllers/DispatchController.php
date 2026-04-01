<?php

namespace App\Http\Controllers;
use App\Models\Load;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\Dispatch;
use Carbon\Carbon;


use Illuminate\Http\Request;

class DispatchController extends Controller
{
  public function index()
{
    $loads = \App\Models\Load::where('status', 'pending')->get();

    $drivers = \App\Models\Driver::all();

    $allTrucks = \App\Models\Truck::where('status', 'active')->get();

    // Attach trucks to each load (temporary logic)
    foreach ($loads as $load) {
        $load->suggestedTrucks = $allTrucks;
    }

    return view('dispatch.index', compact('loads', 'drivers'));
}



public function assign(Request $request, $id)
{
    $load = \App\Models\Load::find($id);

    $startDate = Carbon::parse($load->pickup_date);
    $endDate = $startDate->copy()->addDays($load->trip_days);

    Dispatch::create([
        'load_id' => $load->id,
        'truck_id' => $request->truck_id,
        'driver_id' => null, // auto later
        'assigned_date' => now(),
        'start_date' => $startDate,
        'end_date' => $endDate,
    ]);

    $load->status = 'assigned';
    $load->save();

    return back();
}
}
