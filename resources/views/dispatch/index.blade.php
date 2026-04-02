@extends('layout')

@section('content')

<div class="flex h-screen bg-gray-100">

    <!-- STATUS PANEL -->
    <div class="w-48 bg-white border-r p-4">
        <h3 class="font-semibold mb-4">Status</h3>

        <a href="/dispatch?status=all"
   class="block px-3 py-2 rounded {{ $status == 'all' ? 'bg-gray-200 font-semibold' : '' }}">
    All ({{ $counts['all'] }})
</a>

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
    </div>

    <!-- MAIN -->
    <div class="flex-1 overflow-y-auto p-6 space-y-4">

        @foreach($loads as $load)

        <div x-data="{ open: false }"
             class="rounded-xl shadow p-4
             {{ $load->is_today ? 'bg-red-100' : ($load->is_tomorrow ? 'bg-yellow-100' : 'bg-green-50') }}">

            <!-- COLLAPSED -->
            <div @click="open = !open" class="flex justify-between items-center cursor-pointer">

                <div>
                    <div class="font-semibold text-lg">
                        {{ $load->pickup_date }} • {{ ucfirst($load->pickup_time_slot ?? '') }}
                        • {{ $load->route }}
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

                    <!-- LEFT -->
                    <div class="bg-white p-4 rounded shadow text-sm space-y-1">
                        <p><strong>Customer:</strong> {{ $load->customer_name }}</p>
                        <p><strong>Pickup:</strong> {{ $load->pickup_date }} ({{ ucfirst($load->pickup_time_slot ?? '') }})</p>
                        <p><strong>Delivery:</strong> {{  $load->delivery_date }}</p>
                        <p><strong>Route:</strong> {{ $load->route }}</p>
                        <p><strong>Material:</strong> {{ $load->material }}</p>
                        <p><strong>Weight:</strong> {{ $load->weight }}</p>
                        <p><strong>Price:</strong> ₹{{ $load->price_display }}</p>
                        <p><strong>Priority:</strong> {{ ucfirst($load->priority ?? 'normal') }}</p>

                        @if($load->notes)
                            <p class="text-red-500"><strong>Note:</strong> {{ $load->notes }}</p>
                        @endif
                    </div>

                    <!-- RIGHT (MAP PLACEHOLDER) -->
                    <div class="bg-gray-200 rounded flex items-center justify-center text-sm text-gray-600">
                        Map Coming Soon
                    </div>
                </div>

                <!-- TRUCKS -->
                <div x-data="{ selectedTruck: null }">

                    <h4 class="font-semibold mb-3">
                        Truck Type Required: {{ $load->truck_type_name }}
                    </h4>

                    <div class="flex gap-3 overflow-x-auto">

                        @forelse($load->suggestedTrucks as $truck)

                            <div
                                @click="selectedTruck = {{ $truck->id }}"
                                :class="selectedTruck === {{ $truck->id }} 
                                    ? 'border-blue-600 ring-2 ring-blue-300' 
                                    : 'border-gray-200'"
                                class="min-w-[180px] bg-white p-3 rounded shadow cursor-pointer border transition">

                                <div class="font-semibold">{{ $truck->truck_code }}</div>

                                <div class="text-sm mt-1">
                                    @if($truck->status == 'available')
                                        🟢 Available
                                    @elseif($truck->status == 'reaching')
                                        🔵 {{ $truck->eta }}
                                    @else
                                        🟣 {{ $truck->eta }}
                                    @endif
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
                                :disabled="!selectedTruck"
                                class="bg-blue-600 text-white px-5 py-2 rounded shadow disabled:opacity-50">
                                Assign Load
                            </button>
                        </form>
                    </div>

                    <!-- WARNING -->
                    <div x-show="!selectedTruck" class="text-xs text-red-500 mt-2">
                        Please select a truck before assigning
                    </div>

                </div>

            </div>
        </div>

        @endforeach

    </div>

</div>

@endsection