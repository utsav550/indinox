@extends('layout')

@section('content')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC65AaWhsi_FNGW6KY7WXFoA-YB41UQhyI&libraries=places"></script>


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

    <!-- Driver Assignment -->
    <label class="block mb-1 font-medium">Assign Driver</label>
<select name="driver_id" class="w-full border px-3 py-2 mb-4 rounded">
    <option value="">-- Select Driver --</option>
    
    @foreach($drivers as $driver)
        <option value="{{ $driver->id }}"
            {{ $truck->driver_id == $driver->id ? 'selected' : '' }}>
            {{ $driver->name }} ({{ $driver->phone }})
        </option>
    @endforeach
</select>
    <!-- Status -->
    <label class="block mb-1 font-medium">Status</label>
    <select name="status" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="active" {{ $truck->status == 'active' ? 'selected' : '' }}>Active</option>
        <option value="in_service" {{ $truck->status == 'in_service' ? 'selected' : '' }}>In Service</option>
        <option value="inoperative" {{ $truck->status == 'inoperative' ? 'selected' : '' }}>Inoperative</option>
        <option value="on_hold" {{ $truck->status == 'on_hold' ? 'selected' : '' }}>On Hold</option>
    </select>
    <!-- 📍 Current Location -->
<label class="block mb-1 font-medium">Current Location</label>
<input id="truck_location" name="current_location"
       value="{{ $truck->current_location }}"
       class="w-full border px-3 py-2 mb-4 rounded">

<input type="hidden" name="current_lat" id="current_lat" value="{{ $truck->current_lat }}">
<input type="hidden" name="current_lng" id="current_lng" value="{{ $truck->current_lng }}">

    <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
        Update Truck
    </button>

</form>
</div>
<script>
function getCityFromPlace(place) {
    let city = '';

    for (const component of place.address_components) {
        if (component.types.includes('locality')) {
            city = component.long_name;
        }
    }

    if (!city) {
        for (const component of place.address_components) {
            if (component.types.includes('administrative_area_level_2')) {
                city = component.long_name;
            }
        }
    }

    return city;
}

function initTruckAutocomplete() {
    const input = document.getElementById('truck_location');
    const autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();

        if (!place.geometry) {
            alert("Please select a valid location");
            input.value = '';
            return;
        }

        document.getElementById('current_lat').value = place.geometry.location.lat();
        document.getElementById('current_lng').value = place.geometry.location.lng();

        input.value = getCityFromPlace(place);
    });
}

google.maps.event.addDomListener(window, 'load', initTruckAutocomplete);
</script>

@endsection