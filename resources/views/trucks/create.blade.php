@extends('layout')

@section('content')

<h2 class="text-xl font-bold mb-4">Add Truck</h2>

<div class="flex justify-center">
<form method="POST" action="{{ route('trucks.store') }}" class="bg-white p-6 rounded shadow w-full max-w-lg">
    @csrf

    <!-- Registration Number -->
    <label class="block mb-1 font-medium">Registration Number</label>
    <input name="registration_number" class="w-full border px-3 py-2 mb-4 rounded" required>

    <!-- Truck Type -->
    <label class="block mb-1 font-medium">Truck Type</label>
    <select name="truck_type_id" class="w-full border px-3 py-2 mb-4 rounded" required>
        <option value="">Select Truck Type</option>
        @foreach($types as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
    </select>

    <!-- Capacity -->
    <label class="block mb-1 font-medium">Capacity</label>
    <input name="capacity" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Driver -->
    <label class="block mb-1 font-medium">Assign Driver</label>
<select name="driver_id" class="w-full border px-3 py-2 mb-4 rounded">
    <option value="">-- Select Driver --</option>
    @foreach($drivers as $driver)
        <option value="{{ $driver->id }}">
            {{ $driver->name }} ({{ $driver->phone }})
        </option>
    @endforeach
</select>
    <!-- Ownership -->
    <label class="block mb-1 font-medium">Ownership</label>
    <select name="ownership_type" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="company_owned">Company Owned</option>
        <option value="driver_owned">Driver Owned</option>
    </select>

    <!-- Status -->
    <label class="block mb-1 font-medium">Status</label>
    <select name="status" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="active">Active</option>
        <option value="in_service">In Service</option>
        <option value="inoperative">Inoperative</option>
        <option value="on_hold">On Hold</option>
    </select>

    <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
        Save Truck
    </button>

</form>
</div>

@endsection