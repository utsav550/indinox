@extends('layout')

@section('content')

<h2 class="text-xl font-bold mb-4">Create Load</h2>

<div class="flex justify-center">
<form method="POST" action="{{ route('loads.store') }}" class="bg-white p-6 rounded shadow w-full max-w-lg">
    @csrf

    <!-- Customer -->
    <label class="block mb-1 font-medium">Customer</label>
    <select name="customer_id" class="w-full border px-3 py-2 mb-4 rounded">
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
        @endforeach
    </select>

    <!-- Driver -->

    <!-- Pickup -->
    <label class="block mb-1 font-medium">Pickup Location</label>
    <input name="pickup_location" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Delivery -->
    <label class="block mb-1 font-medium">Delivery Location</label>
    <input name="delivery_location" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Material -->
    <label class="block mb-1 font-medium">Material</label>
    <input name="material" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Weight -->
    <label class="block mb-1 font-medium">Weight</label>
    <input name="weight" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Date -->
    <label class="block mb-1 font-medium">Pickup Date</label>
    <input type="date" name="pickup_date" class="w-full border px-3 py-2 mb-4 rounded">

    <label class="block mb-1 font-medium">Pickup Time Slot</label>
<select name="pickup_time_slot" class="w-full border px-3 py-2 mb-4 rounded" required>
    <option value="">Select Time Slot</option>
    <option value="early_morning">Early Morning (4AM–8AM)</option>
    <option value="morning">Morning (8AM–12PM)</option>
    <option value="afternoon">Afternoon (12PM–4PM)</option>
    <option value="evening">Evening (4PM–8PM)</option>
    <option value="night">Night (8PM–12AM)</option>
    <option value="late_night">Late Night (12AM–4AM)</option>
</select>
   

    <!-- Price -->
    <label class="block mb-1 font-medium">Price</label>
    <input name="price" class="w-full border px-3 py-2 mb-4 rounded">

   

    <label class="block mb-1 font-medium">Truck Type Required</label>
<select name="truck_type_required_id" class="w-full border px-3 py-2 mb-4 rounded">
    <option value="">Select Type</option>
    @foreach($types as $type)
        <option value="{{ $type->id }}">{{ $type->name }}</option>
    @endforeach
</select>

<label class="block mb-1 font-medium">Priority</label>
<select name="priority" class="w-full border px-3 py-2 mb-4 rounded">
    <option value="normal">Normal</option>
    <option value="high">High</option>
    <option value="low">Low</option>
</select>
<label class="block mb-1 font-medium">Trip Days</label>
<input type="number" name="trip_days" value="1" class="w-full border px-3 py-2 mb-4 rounded">

<label class="block mb-1 font-medium">Notes</label>
<textarea name="notes" class="w-full border px-3 py-2 mb-4 rounded"></textarea>
    <!-- Submit -->
    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded w-full">
        Save Load
    </button>

</form>
</div>

@endsection