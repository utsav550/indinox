<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\TruckType;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
        public function index()
{
    $trucks = Truck::all();
    return view('trucks.index', compact('trucks'));
}
    

    /**
     * Show the form for creating a new resource.
     */
  

public function create()
{
    $types = TruckType::all();

    return view('trucks.create', compact('types'));
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // Get last truck
    $lastTruck = \App\Models\Truck::orderBy('id', 'desc')->first();

    if ($lastTruck) {
        // Extract number from INOX001
        $lastNumber = (int) substr($lastTruck->truck_code, 4);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }

    // Generate code
    $truckCode = 'INOX' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    // Save truck
    \App\Models\Truck::create([
        'truck_code' => $truckCode,
        'registration_number' => $request->registration_number,
        'truck_type_id' => $request->truck_type_id,
        'capacity' => $request->capacity,
        'ownership_type' => $request->ownership_type,
        'status' => $request->status,
    ]);

    return redirect()->route('trucks.index');
}
    /**
     * Display the specified resource.
     */
    public function show(Truck $truck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $truck = \App\Models\Truck::findOrFail($id);
    $types = \App\Models\TruckType::all();

    return view('trucks.edit', compact('truck', 'types'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $truck = \App\Models\Truck::findOrFail($id);

    $truck->update([
        'registration_number' => $request->registration_number,
        'truck_type_id' => $request->truck_type_id,
        'capacity' => $request->capacity,
        'ownership_type' => $request->ownership_type,
        'status' => $request->status,
    ]);

    return redirect()->route('trucks.index');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Truck $truck)
    {
        //
    }
}
