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
        $status = $request->status ?? 'pending';

        $query = Load::with(['customer', 'truckType']);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $counts = [
            'all' => Load::count(),
            'pending' => Load::where('status', 'pending')->count(),
            'assigned' => Load::where('status', 'assigned')->count(),
            'in_transit' => Load::where('status', 'in_transit')->count(),
            'delivered' => Load::where('status', 'delivered')->count(),
            'expired' => Load::where('status', 'expired')->count(),
        ];

        $loads = $query->get()
            ->map(function ($load) use ($today) {

                // BASIC DATA
                $load->customer_name = $load->customer->name ?? 'N/A';

                $pickupDate = Carbon::parse($load->pickup_date);
                $delivery_date = Carbon::parse($pickupDate->copy()->addDays($load->trip_days));
                $load->delivery_date = $delivery_date->format('d-m-y');

                $load->route = ($load->pickup_location ?? '') . ' → ' . ($load->delivery_location ?? '');
                $load->material_display = $load->material . ' • ' . $load->weight;
                $load->price_display = number_format($load->price);
                $load->truck_type_name = $load->truckType->name ?? 'N/A';

                $load->is_today = $pickupDate->isSameDay($today);
                $load->is_tomorrow = $pickupDate->isSameDay($today->copy()->addDay());

                // 🚚 TRUCK SUGGESTION (ONLY FOR PENDING)
                if ($load->status === 'pending') {

                    $trucks = Truck::where('status', 'active')
                        ->where('truck_type_id', $load->truck_type_required_id)
                        ->get()
                        ->map(function ($truck) use ($pickupDate, $load) {

                            // ---------- AVAILABILITY ----------
                            $dispatch = Dispatch::where('truck_id', $truck->id)
                                ->where(function ($q) use ($pickupDate) {
                                    $q->whereDate('start_date', '<=', $pickupDate)
                                      ->whereDate('end_date', '>=', $pickupDate);
                                })
                                ->latest()
                                ->first();

                            if (!$dispatch) {
                                $truck->status = 'available';
                                $truck->eta = 'Ready';
                                $statusScore = 1;
                            } else {
                                $endDate = Carbon::parse($dispatch->end_date);

                                if ($endDate->isSameDay($pickupDate)) {
                                    $truck->status = 'reaching';
                                    $truck->eta = 'Available later today';
                                    $statusScore = 2;
                                } else {
                                    $truck->status = 'busy';
                                    $truck->eta = 'Busy till ' . $endDate->format('d M');
                                    $statusScore = 5;
                                }
                            }

                            // ---------- DISTANCE ----------
                            if (
                                $truck->current_lat && $truck->current_lng &&
                                $load->pickup_lat && $load->pickup_lng
                            ) {
                                $earthRadius = 6371;

                                $latFrom = deg2rad($truck->current_lat);
                                $lonFrom = deg2rad($truck->current_lng);
                                $latTo = deg2rad($load->pickup_lat);
                                $lonTo = deg2rad($load->pickup_lng);

                                $latDelta = $latTo - $latFrom;
                                $lonDelta = $lonTo - $lonFrom;

                                $angle = 2 * asin(sqrt(
                                    pow(sin($latDelta / 2), 2) +
                                    cos($latFrom) * cos($latTo) *
                                    pow(sin($lonDelta / 2), 2)
                                ));

                                $truck->distance = round($angle * $earthRadius, 2);
                            } else {
                                $truck->distance = 9999;
                            }

                            // ---------- DRIVER PENALTY ----------
                            $driverPenalty = $truck->driver_id ? 0 : 100;

                            // ---------- FINAL SCORE ----------
                            $truck->score = $statusScore + $truck->distance + $driverPenalty;

                            return $truck;
                        })
                        ->sortBy('score')
                        ->values()
                        ->take(6);

                    // MARK BEST
                    if ($trucks->count()) {
                        $trucks[0]->is_recommended = true;
                    }

                    $load->suggestedTrucks = $trucks;
                }

                // ✅ ASSIGNED LOAD DATA
                if ($load->status === 'assigned') {
                    $dispatch = Dispatch::where('load_id', $load->id)->latest()->first();
if ($dispatch) {
    $truck = Truck::with('driver')->find($dispatch->truck_id);

    // 📍 CALCULATE DISTANCE
    if (
        $truck->current_lat && $truck->current_lng &&
        $load->pickup_lat && $load->pickup_lng
    ) {
        $earthRadius = 6371;

        $latFrom = deg2rad($truck->current_lat);
        $lonFrom = deg2rad($truck->current_lng);
        $latTo = deg2rad($load->pickup_lat);
        $lonTo = deg2rad($load->pickup_lng);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) *
            pow(sin($lonDelta / 2), 2)
        ));

        $truck->distance = round($angle * $earthRadius, 2);
    } else {
        $truck->distance = null;
    }

    $load->assignedTruck = $truck;
    $load->dispatchDetails = $dispatch;
}
                }

                return $load;
            });

        return view('dispatch.index', compact('loads', 'status', 'counts'));
    }

    public function assign(Request $request, $id)
    {
        $load = Load::findOrFail($id);

        // ❌ BLOCK IF NOT PENDING
        if ($load->status !== 'pending') {
            return back()->with('error', 'Load already assigned');
        }

        $truck = Truck::findOrFail($request->truck_id);

        $startDate = Carbon::parse($load->pickup_date);
        $endDate = $startDate->copy()->addDays($load->trip_days);

        Dispatch::create([
            'load_id' => $load->id,
            'truck_id' => $truck->id,
            'driver_id' => $truck->driver_id,
            'assigned_date' => now(),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $load->status = 'assigned';
        $load->save();

        return back();
    }
    public function unassign($id)
{
    $load = Load::findOrFail($id);

    // Find dispatch
    $dispatch = Dispatch::where('load_id', $load->id)->latest()->first();

    if ($dispatch) {
        $dispatch->delete();
    }

    // Update load back to pending
    $load->status = 'pending';
    $load->save();

    return back()->with('success', 'Load unassigned successfully');
}
}