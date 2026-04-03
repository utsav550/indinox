<?php

namespace App\Http\Controllers;

use App\Models\Load;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\TruckType;
use Carbon\Carbon;

class LoadController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        // ✅ Expire old pending loads
        Load::where('status', 'pending')
            ->whereDate('pickup_date', '<', $today)
            ->update([
                'status' => 'expired'
            ]);

        $query = Load::with('customer', 'driver', 'truckType');

        // Filters
        if ($request->search) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Sorting
        $loads = $query
            ->orderBy('pickup_date')
            ->get()
            ->sortBy(function ($load) {
                $order = [
                    'early_morning' => 1,
                    'morning' => 2,
                    'afternoon' => 3,
                    'evening' => 4,
                    'night' => 5,
                    'late_night' => 6,
                ];

                return $order[$load->pickup_time_slot] ?? 99;
            });

        return view('loads.index', compact('loads'));
    }

    public function create()
    {
        $customers = Customer::all();
        $types = TruckType::all();

        return view('loads.create', compact('customers', 'types'));
    }

    public function store(Request $request)
    {
        Load::create([
    'customer_id' => $request->customer_id,

    // ✅ STORE CITY IN LOCATION
    'pickup_location' => $request->pickup_city,
    'delivery_location' => $request->delivery_city,

    // ✅ STORE FULL ADDRESS
    'pickup_address' => $request->pickup_address,
    'pickup_lat' => $request->pickup_lat,
    'pickup_lng' => $request->pickup_lng,

    'delivery_address' => $request->delivery_address,
    'delivery_lat' => $request->delivery_lat,
    'delivery_lng' => $request->delivery_lng,

    // OTHER FIELDS
    'material' => $request->material,
    'weight' => $request->weight,
    'pickup_date' => $request->pickup_date,
    'pickup_time_slot' => $request->pickup_time_slot,
    'price' => $request->price,
    'truck_type_required_id' => $request->truck_type_required_id,
    'priority' => $request->priority,
    'trip_days' => $request->trip_days,
    'notes' => $request->notes,

    'status' => 'pending',
]);
        return redirect()->route('loads.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $load = Load::findOrFail($id);
        $load->status = $request->status;
        $load->save();

        return back();
    }

    public function edit($id)
    {
        $load = Load::findOrFail($id);
        $customers = Customer::all();

        return view('loads.edit', compact('load', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $load = Load::findOrFail($id);
        $load->update($request->all());

        return redirect()->route('loads.index');
    }
}