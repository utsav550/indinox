@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-100">

    {{-- SIDEBAR --}}
    <div class="w-60 bg-white shadow-md p-4">
        <h2 class="text-xl font-bold mb-6">Indinox</h2>

        <nav class="space-y-3">
            <a href="#" class="block font-medium text-gray-700">Dashboard</a>
            <a href="#" class="block font-medium text-gray-700">Customers</a>
            <a href="#" class="block font-medium text-gray-700">Loads</a>
            <a href="#" class="block font-medium text-gray-700">Drivers</a>
            <a href="#" class="block font-medium text-gray-700">Trucks</a>
        </nav>
    </div>

    {{-- STATUS PANEL --}}
    <div class="w-48 bg-gray-50 border-r p-4">
        <h3 class="font-semibold mb-4">Status</h3>

        <div class="space-y-2">
            <button class="w-full text-left px-3 py-2 rounded bg-white shadow">
                All ({{ $loads->count() }})
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-200">
                Pending
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-200">
                Assigned
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-200">
                In Transit
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-200">
                Delivered
            </button>
        </div>
    </div>

    {{-- MAIN DISPATCH BOARD --}}
    <div class="flex-1 overflow-y-auto p-6 space-y-4">

        @foreach($loads as $load)
            <div x-data="{ open: false }"
                 class="rounded-xl shadow p-4
                 {{ $load->is_today ? 'bg-red-100' : ($load->is_tomorrow ? 'bg-yellow-100' : 'bg-green-100') }}">

                {{-- COLLAPSED --}}
                <div @click="open = !open" class="flex justify-between items-center cursor-pointer">

                    <div>
                        <div class="font-semibold text-lg">
                            {{ $load->pickup_date }} • {{ $load->time_slot }}
                            — {{ $load->pickup }} → {{ $load->drop }}
                        </div>

                        <div class="text-sm text-gray-600">
                            {{ $load->customer }} • {{ $load->material }} • {{ $load->weight }}
                        </div>

                        <div class="text-sm mt-1">
                            ₹{{ number_format($load->price) }} • {{ $load->truck_type }}
                            • {{ ucfirst($load->status) }}
                        </div>
                    </div>

                    <button class="text-blue-600 font-medium">
                        <span x-text="open ? 'Collapse' : 'Expand'"></span>
                    </button>
                </div>

                {{-- EXPANDED --}}
                <div x-show="open" x-transition class="mt-6 border-t pt-4">

                    {{-- TOP SECTION --}}
                    <div class="grid grid-cols-3 gap-4">

                        {{-- LOAD INFO --}}
                        <div class="col-span-2 bg-white p-4 rounded shadow">
                            <h4 class="font-semibold mb-2">Load Info</h4>

                            <p><strong>Customer:</strong> {{ $load->customer }}</p>
                            <p><strong>Pickup:</strong> {{ $load->pickup_date }} ({{ $load->time_slot }})</p>
                            <p><strong>Delivery:</strong> {{ $load->delivery_date }}</p>
                            <p><strong>Route:</strong> {{ $load->pickup }} → {{ $load->drop }}</p>
                            <p><strong>Material:</strong> {{ $load->material }}</p>
                            <p><strong>Weight:</strong> {{ $load->weight }}</p>
                            <p><strong>Price:</strong> ₹{{ number_format($load->price) }}</p>
                            <p><strong>Priority:</strong> {{ $load->priority }}</p>
                        </div>

                        {{-- MAP --}}
                        <div class="bg-gray-200 rounded flex items-center justify-center">
                            Map Coming Soon
                        </div>
                    </div>

                    {{-- TRUCK SELECTION --}}
                    <div x-data="{ selectedTruck: null }" class="mt-4">
                        <h4 class="font-semibold mb-2">Select Truck</h4>

                        <div class="flex gap-3 overflow-x-auto">

                            @foreach($load->suggestedTrucks ?? [] as $truck)
                                <div
                                    @click="selectedTruck = {{ $truck->id }}"
                                    :class="selectedTruck === {{ $truck->id }} 
                                        ? 'border-blue-600 ring-2 ring-blue-300' 
                                        : 'border-gray-200'"
                                    class="min-w-[180px] bg-white p-3 rounded shadow cursor-pointer border transition">

                                    <div class="font-semibold">{{ $truck->name }}</div>

                                    <div class="text-sm mt-1">
                                        @if($truck->status == 'available')
                                            🟢 Available
                                        @elseif($truck->status == 'reaching')
                                            🔵 Reaching
                                        @else
                                            🟣 Busy
                                        @endif
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $truck->eta ?? 'N/A' }}
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{-- ASSIGN --}}
                        <div class="mt-4 flex justify-between items-center">

                            <div class="text-sm">
                                Driver: <strong>Auto Assigned</strong>
                            </div>

                            <form method="POST" action="{{ route('dispatch.assign', $load->id) }}">
                                @csrf

                                <input type="hidden" name="truck_id" :value="selectedTruck">

                                <button 
                                    :disabled="!selectedTruck"
                                    class="bg-blue-600 text-white px-4 py-2 rounded shadow disabled:opacity-50">
                                    Assign Load
                                </button>
                            </form>
                        </div>

                        {{-- WARNING --}}
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