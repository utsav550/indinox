<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Truck;
use App\Models\TruckType;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $pending     = Driver::where('status', 'pending')->latest('applied_at')->get();
        $approved    = Driver::where('status', 'approved')->latest()->get();
        $onLeave     = Driver::where('status', 'on_leave')->latest()->get();
        $unavailable = Driver::where('status', 'unavailable')->latest()->get();
        $leftCompany = Driver::where('status', 'left_company')->latest()->get();
        $rejected    = Driver::where('status', 'rejected')->latest()->get();

        return view('drivers.index', compact(
            'pending', 'approved', 'onLeave',
            'unavailable', 'leftCompany', 'rejected'
        ));
    }

    public function create()
    {
        return view('drivers.create');
    }

    public function store(Request $request)
    {
        Driver::create([
            'name'           => $request->name,
            'phone'          => $request->phone,
            'license_number' => $request->license_number,
            'status'         => 'approved',
            'driver_type'    => 'fleet_driver',
        ]);

        return redirect()->route('drivers.index');
    }

    // Change driver status from the admin panel
    public function updateStatus(Request $request, $id)
    {
        $driver    = Driver::findOrFail($id);
        $newStatus = $request->status;

        // Find truck currently linked to this driver
        $truck = Truck::where('driver_id', $driver->id)->first();

        if (in_array($newStatus, ['on_leave', 'unavailable', 'left_company'])) {
            if ($truck) {
                $truck->driver_id = null;

                // Owner-operator leaves permanently → deactivate their truck
                if ($newStatus === 'left_company' && $driver->driver_type === 'owner_operator') {
                    $truck->status = 'inactive';
                }

                $truck->save();
            }
        }

        $driver->status      = $newStatus;
        $driver->admin_notes = $request->notes ?? $driver->admin_notes;
        $driver->save();

        return back()->with('success', 'Driver status updated to ' . ucfirst(str_replace('_', ' ', $newStatus)) . '.');
    }

    public function approve(Request $request, $id)
    {
        $driver          = Driver::findOrFail($id);
        $driver->status  = 'approved';
        $driver->admin_notes = $request->admin_notes;
        $driver->save();

        if ($driver->driver_type === 'owner_operator' && $request->truck_type_id) {
            $lastTruck  = Truck::orderBy('id', 'desc')->first();
            $nextNumber = $lastTruck ? ((int) substr($lastTruck->truck_code, 4)) + 1 : 1;
            $truckCode  = 'INOX' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            Truck::create([
                'truck_code'          => $truckCode,
                'registration_number' => $request->registration_number,
                'truck_type_id'       => $request->truck_type_id,
                'capacity'            => $request->capacity,
                'ownership_type'      => 'owner',
                'status'              => 'active',
                'driver_id'           => $driver->id,
            ]);
        }

        return back()->with('success', "Driver {$driver->name} approved.");
    }

    public function reject(Request $request, $id)
    {
        $driver              = Driver::findOrFail($id);
        $driver->status      = 'rejected';
        $driver->admin_notes = $request->admin_notes;
        $driver->save();

        return back()->with('success', "Driver {$driver->name} rejected.");
    }

    public function joinForm()
    {
        $truckTypes = TruckType::all();
        return view('drivers.join', compact('truckTypes'));
    }

    public function joinStore(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'license_number' => 'required|string|max:100',
            'driver_type'    => 'required|in:fleet_driver,owner_operator',
        ]);

        Driver::create([
            'name'           => $request->name,
            'phone'          => $request->phone,
            'license_number' => $request->license_number,
            'status'         => 'pending',
            'driver_type'    => $request->driver_type,
            'applied_at'     => now(),
            'admin_notes'    => $request->driver_type === 'owner_operator'
                ? json_encode([
                    'truck_registration' => $request->registration_number,
                    'truck_type_id'      => $request->truck_type_id,
                    'truck_capacity'     => $request->capacity,
                ])
                : null,
        ]);

        return redirect()->route('drivers.join.success');
    }

    public function joinSuccess()
    {
        return view('drivers.join-success');
    }
}