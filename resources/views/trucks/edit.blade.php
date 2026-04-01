@extends('layout')

@section('content')

<h2 class="text-xl font-bold mb-4">Edit Truck</h2>

<div class="flex justify-center">
<form method="POST" action="{{ route('trucks.update', $truck->id) }}" class="bg-white p-6 rounded shadow w-full max-w-lg">
    @csrf
    @method('PUT')

    <!-- Registration Number -->
    <label class="block mb-1 font-medium">Registration Number</label>
    <input name="registration_number" value="{{ $truck->registration_number }}" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Truck Type -->
    <label class="block mb-1 font-medium">Truck Type</label>
    <select name="truck_type_id" class="w-full border px-3 py-2 mb-4 rounded">
        @foreach($types as $type)
            <option value="{{ $type->id }}" {{ $truck->truck_type_id == $type->id ? 'selected' : '' }}>
                {{ $type->name }}
            </option>
        @endforeach
    </select>

    <!-- Capacity -->
    <label class="block mb-1 font-medium">Capacity</label>
    <input name="capacity" value="{{ $truck->capacity }}" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Ownership -->
    <label class="block mb-1 font-medium">Ownership</label>
    <select name="ownership_type" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="company_owned" {{ $truck->ownership_type == 'company_owned' ? 'selected' : '' }}>Company Owned</option>
        <option value="driver_owned" {{ $truck->ownership_type == 'driver_owned' ? 'selected' : '' }}>Driver Owned</option>
    </select>

    <!-- Status -->
    <label class="block mb-1 font-medium">Status</label>
    <select name="status" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="active" {{ $truck->status == 'active' ? 'selected' : '' }}>Active</option>
        <option value="in_service" {{ $truck->status == 'in_service' ? 'selected' : '' }}>In Service</option>
        <option value="inoperative" {{ $truck->status == 'inoperative' ? 'selected' : '' }}>Inoperative</option>
        <option value="on_hold" {{ $truck->status == 'on_hold' ? 'selected' : '' }}>On Hold</option>
    </select>

    <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
        Update Truck
    </button>

</form>
</div>

@endsection