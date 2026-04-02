<?php

namespace App\Http\Controllers;

use App\Models\Load;
use App\Models\Truck;
use App\Models\Dispatch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\LoadService;


class DispatchController extends Controller
{
    public function index(Request $request)
{
    LoadService::updateExpired();

    $today = Carbon::today();

    $status = $request->status;

    $query = Load::with(['customer', 'truckType']);

    // ---------- STATUS FILTER ----------
    if ($status && $status !== 'all') {
        $query->where('status', $status);
    }
    $counts = [
    'all' => Load::count(),
    'pending' => Load::where('status', 'pending')->count(),
    'assigned' => Load::where('status', 'assigned')->count(),
    'in_transit' => Load::where('status', 'in_transit')->count(),
    'delivered' => Load::where('status', 'delivered')->count(),
    'expired' => Load::where('status', 'expired')->count(), // ✅ ADD THIS
];
    $loads = $query->get()
        ->map(function ($load) use ($today) {

        //

        



            // CLEAN DATA
             $load->customer_name = $load->customer->name ?? 'N/A';

                 $pickupDate = Carbon::parse($load->pickup_date);
                 $delivery_date = Carbon::parse($pickupDate->addDays($load->trip_days));
                    $load->delivery_date = $delivery_date->format('d-m-y');
                $load->route = ($load->pickup_location ?? '') . ' → ' . ($load->delivery_location ?? '');

                $load->material_display = $load->material . ' • ' . $load->weight;

                $load->price_display = number_format($load->price);

                $load->truck_type_name = $load->truckType->name ?? 'N/A';

            // DATE LOGIC
            $pickupDate = Carbon::parse($load->pickup_date);
            $load->is_today = $pickupDate->isSameDay($today);
            $load->is_tomorrow = $pickupDate->isSameDay($today->copy()->addDay());

            // TRUCK LOGIC (same as before)
            $trucks = Truck::where('status', 'active')
                ->where('truck_type_id', $load->truck_type_required_id)
                ->get()
                ->map(function ($truck) use ($pickupDate) {

                    $dispatch = Dispatch::where('truck_id', $truck->id)
                        ->where(function ($q) use ($pickupDate) {
                            $q->whereDate('start_date', '<=', $pickupDate)
                              ->whereDate('end_date', '>', $pickupDate);
                        })
                        ->latest()
                        ->first();

                    if (!$dispatch) {
                        $truck->status = 'available';
                        $truck->eta = 'Ready';
                    } else {
                        $endDate = Carbon::parse($dispatch->end_date);

                        if ($endDate->isSameDay($pickupDate)) {
                            $truck->status = 'reaching';
                            $truck->eta = 'Available on ' . $endDate->format('d M');
                        } else {
                            $truck->status = 'busy';
                            $truck->eta = 'Busy till ' . $endDate->format('d M');
                        }
                    }

                    return $truck;
                })
                ->sortBy(fn($t) => match ($t->status) {
                    'available' => 1,
                    'reaching' => 2,
                    'busy' => 3,
                    default => 4
                })
                ->values()
                ->take(6);

            $load->suggestedTrucks = $trucks;

            return $load;
        });

    return view('dispatch.index', compact('loads', 'status', 'counts'));
}


    

    public function assign(Request $request, $id)
    {
        $load = Load::findOrFail($id);
        $truck = \App\Models\Truck::findOrFail($request->truck_id);


        $startDate = Carbon::parse($load->pickup_date);
        $endDate = $startDate->copy()->addDays($load->trip_days);

        Dispatch::create([
            'load_id' => $load->id,
            'truck_id' => $request->truck_id,
            'driver_id' =>$truck->driver_id,
            'assigned_date' => now(),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $load->status = 'assigned';
        $load->save();

        return back();
    }
}