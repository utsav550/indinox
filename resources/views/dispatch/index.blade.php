@extends('layout')

@section('content')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC65AaWhsi_FNGW6KY7WXFoA-YB41UQhyI"></script>

<div class="flex h-screen bg-gray-100">

    <!-- STATUS PANEL -->
    <div class="w-48 bg-white border-r p-4">
        <h3 class="font-semibold mb-4">Status</h3>

        <a href="/dispatch?status=pending"
           class="block px-3 py-2 rounded {{ $status == 'pending' ? 'bg-gray-200 font-semibold' : '' }}">
            Pending ({{ $counts['pending'] }})
        </a>

        <a href="/dispatch?status=assigned"
           class="block px-3 py-2 rounded {{ $status == 'assigned' ? 'bg-gray-200 font-semibold' : '' }}">
            Assigned ({{ $counts['assigned'] }})
        </a>

        <a href="/dispatch?status=in_transit"
           class="block px-3 py-2 rounded {{ $status == 'in_transit' ? 'bg-gray-200 font-semibold' : '' }}">
            In Transit ({{ $counts['in_transit'] }})
        </a>

        <a href="/dispatch?status=delivered"
           class="block px-3 py-2 rounded {{ $status == 'delivered' ? 'bg-gray-200 font-semibold' : '' }}">
            Delivered ({{ $counts['delivered'] }})
        </a>

        <a href="/dispatch?status=expired"
           class="block px-3 py-2 rounded {{ $status == 'expired' ? 'bg-red-100 font-semibold text-red-700' : '' }}">
            Expired ({{ $counts['expired'] ?? 0 }})
        </a>

        <a href="/dispatch?status=all"
           class="block px-3 py-2 rounded {{ $status == 'all' ? 'bg-gray-200 font-semibold' : '' }}">
            All ({{ $counts['all'] }})
        </a>
    </div>

    <!-- MAIN -->
    <div class="flex-1 overflow-y-auto p-6 space-y-4">

        @foreach($loads as $load)

        <div x-data="{ open: false }"
             class="rounded-xl shadow p-4
             {{ $load->is_today ? 'bg-red-100' : ($load->is_tomorrow ? 'bg-yellow-100' : 'bg-green-50') }}">

            <!-- COLLAPSED -->
           <div 
    @click="
        open = !open;
        if(open){
            loadMap(
                {{ $load->id }},
                {{ $load->pickup_lat ?? 0 }},
                {{ $load->pickup_lng ?? 0 }},
                {{ $load->delivery_lat ?? 0 }},
                {{ $load->delivery_lng ?? 0 }},
                [
                    @foreach($load->suggestedTrucks as $truck)
                        {
                            lat: {{ $truck->current_lat ?? 0 }},
                            lng: {{ $truck->current_lng ?? 0 }},
                            code: '{{ $truck->truck_code }}'
                        },
                    @endforeach
                ]
            );
        }
    "
    class="flex justify-between items-center cursor-pointer"
>

                <div>
                    <div class="font-semibold text-lg">
                        {{ $load->pickup_date }} • {{ ucfirst($load->pickup_time_slot ?? '') }}
                        • <span title="{{ $load->route }}">
                            {{ \Illuminate\Support\Str::limit($load->route, 50) }}
                        </span>
                    </div>

                    <div class="text-sm text-gray-600">
                        {{ $load->customer_name }} • {{ $load->material_display }}
                    </div>

                    <div class="text-sm mt-1">
                        ₹{{ $load->price_display }} • {{ $load->truck_type_name }}
                        • {{ ucfirst($load->status) }}
                    </div>
                </div>

                <button class="text-blue-600 font-medium">
                    <span x-text="open ? 'Collapse' : 'Expand'"></span>
                </button>
            </div>

            <!-- EXPANDED -->
            <div x-show="open" x-transition class="mt-6 border-t pt-4 space-y-6">

                <!-- TOP -->
                <div class="grid grid-cols-2 gap-4">

                    <div class="bg-white p-4 rounded shadow text-sm space-y-1">
                        <p><strong>Customer:</strong> {{ $load->customer_name }}</p>
                        <p><strong>Pickup:</strong> {{ $load->pickup_date }} ({{ ucfirst($load->pickup_time_slot ?? '') }})</p>
                        <p><strong>Delivery:</strong> {{ $load->delivery_date }}</p>

                        <p>
                            <strong>Route:</strong>
                            <span title="{{ $load->route }}">
                                {{ \Illuminate\Support\Str::limit($load->route, 70) }}
                            </span>
                        </p>

                        <p><strong>Material:</strong> {{ $load->material }}</p>
                        <p><strong>Weight:</strong> {{ $load->weight }}</p>
                        <p><strong>Price:</strong> ₹{{ $load->price_display }}</p>
                        <p><strong>Priority:</strong> {{ ucfirst($load->priority ?? 'normal') }}</p>

                        @if($load->notes)
                            <p class="text-red-500"><strong>Note:</strong> {{ $load->notes }}</p>
                        @endif
                    </div>

                    <div class="bg-gray-200 rounded flex items-center justify-center text-sm text-gray-600">
    <div id="map-{{ $load->id }}" class="w-full h-64 rounded"></div>
                    </div>
                </div>

                <!-- 🔥 MAIN LOGIC SPLIT -->
                @if($load->status === 'assigned')

                    <!-- ✅ SHOW ASSIGNED ONLY -->
                    <div class="bg-green-50 p-4 rounded border">

                        <h4 class="font-semibold mb-3">Assigned Truck</h4>

                        <div class="bg-white p-3 rounded shadow">

                            <div class="font-semibold text-lg">
                                {{ $load->assignedTruck->truck_code ?? 'N/A' }}
                            </div>

                            <div class="text-sm mt-1">
                                🟢 Assigned
                            </div>

                            <div class="text-sm mt-1">
                                Driver: {{ $load->assignedTruck->driver->name ?? 'Not Assigned' }}
                            </div>

                            <div class="text-sm mt-1">
                                Start: {{ $load->dispatchDetails->start_date }}
                            </div>

                            <div class="text-sm mt-1">
                                End: {{ $load->dispatchDetails->end_date }}
                            </div>

                        </div>

                    </div>

                @else

                    <!-- 🚚 NORMAL TRUCK SELECTION -->
                    <div x-data="{ selectedTruck: null, hasDriver: false }">

                        <h4 class="font-semibold mb-3">
                            Truck Type Required: {{ $load->truck_type_name }}
                        </h4>

                        <div class="flex gap-3 overflow-x-auto">

                            @forelse($load->suggestedTrucks as $truck)

                                <div
                                    @click="{{ $truck->driver_id ? "selectedTruck = {$truck->id}; hasDriver = true" : "hasDriver = false" }}"
                                    :class="selectedTruck === {{ $truck->id }} 
                                        ? 'border-blue-600 ring-2 ring-blue-300' 
                                        : 'border-gray-200'"
                                    class="min-w-[180px] bg-white p-3 rounded shadow cursor-pointer border transition">

                                    <div class="font-semibold">{{ $truck->truck_code }}</div>

                                    <div class="text-sm mt-1">

                                        @if(isset($truck->is_recommended) && $truck->is_recommended)
                                            <div class="text-xs bg-green-500 text-white px-2 py-1 rounded inline-block mb-1">
                                                🔥 Recommended
                                            </div>
                                        @endif

                                        @if(!$truck->driver_id)
                                            🔴 No Driver
                                        @elseif($truck->status == 'available')
                                            🟢 Available
                                        @elseif($truck->status == 'reaching')
                                            🔵 {{ $truck->eta }}
                                        @else
                                            🟣 {{ $truck->eta }}
                                        @endif

                                        <div class="text-xs text-gray-500 mt-1">
                                            📍 {{ $truck->distance }} km away
                                        </div>

                                    </div>

                                </div>

                            @empty
                                <div class="text-sm text-gray-500">
                                    No trucks available
                                </div>
                            @endforelse

                        </div>

                        <!-- ASSIGN -->
                        <div class="mt-5 flex justify-between items-center">

                            <div class="text-sm">
                                Driver: <strong>Auto Assigned</strong>
                            </div>

                            <form method="POST" action="{{ route('dispatch.assign', $load->id) }}">
                                @csrf

                                <input type="hidden" name="truck_id" :value="selectedTruck">

                                <button 
                                    :disabled="!selectedTruck || !hasDriver"
                                    class="bg-blue-600 text-white px-5 py-2 rounded shadow disabled:opacity-50">
                                    Assign Load
                                </button>
                            </form>
                        </div>

                    </div>

                @endif

            </div>
        </div>

        @endforeach

    </div>

</div>
<script>
function loadMap(loadId, pickupLat, pickupLng, deliveryLat, deliveryLng, trucks) {

    const mapElement = document.getElementById("map-" + loadId);

    if (mapElement.dataset.loaded) return;
    mapElement.dataset.loaded = true;

    const pickup = { lat: pickupLat, lng: pickupLng };
    const delivery = { lat: deliveryLat, lng: deliveryLng };

    const map = new google.maps.Map(mapElement, {
        zoom: 7,
        center: pickup,
    });

    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer();

    directionsRenderer.setMap(map);

    // 🛣 ROUTE
    directionsService.route({
        origin: pickup,
        destination: delivery,
        travelMode: 'DRIVING'
    }, function(result, status) {
        if (status === 'OK') {
            directionsRenderer.setDirections(result);
        }
    });

    // 📍 Pickup
    new google.maps.Marker({
        position: pickup,
        map: map,
        label: "P"
    });

    // 📍 Delivery
    new google.maps.Marker({
        position: delivery,
        map: map,
        label: "D"
    });

    // 🚚 MULTIPLE TRUCKS
    if (trucks && trucks.length) {
        trucks.forEach(truck => {
            if (truck.lat && truck.lng) {
                new google.maps.Marker({
    position: { lat: truck.lat, lng: truck.lng },
    map: map,
    title: truck.code,
    icon: {
        url: "https://maps.google.com/mapfiles/kml/shapes/truck.png",
        scaledSize: new google.maps.Size(40, 40)
    }
});
            }
        });
    }
}
</script>

@endsection