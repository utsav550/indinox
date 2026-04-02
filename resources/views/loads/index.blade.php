@extends('layout')

@section('content')

<h2 class="text-xl font-bold mb-4">Loads</h2>

<a href="{{ route('loads.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Load</a>

<table class="w-full mt-4 bg-white shadow">
    <tr class="bg-gray-200">
        <th class="p-2">Customer</th>
<th class="p-2">Pickup</th>
<th class="p-2">Delivery</th>
<th class="p-2">Price</th>
<th class="p-2">Truck Type</th>
<th class="p-2">Pickup Slot</th>
<th class="p-2">Priority</th>
<th class="p-2">Status</th>
<th class="p-2">Notes</th>
<th class="p-2">Action</th>
        
    </tr>

    @foreach($loads as $load)
    <tr class="border-t">
       <tr class="border-t">
    <td class="p-2 text-center">{{ $load->customer->name }}</td>
    <td class="p-2 text-center">{{ $load->pickup_location }}</td>
    <td class="p-2 text-center">{{ $load->delivery_location }}</td>
    <td class="p-2 text-center">{{ $load->price }}</td>

    <td class="p-2 text-center">
        {{ $load->truckType->name ?? 'N/A' }}
    </td>

    <td class="p-2 text-center">
    @php
        $slot = $load->pickup_time_slot;
    @endphp

    @if($slot == 'early_morning')
        <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs">Early Morning</span>

    @elseif($slot == 'morning')
        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Morning</span>

    @elseif($slot == 'afternoon')
        <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-xs">Afternoon</span>

    @elseif($slot == 'evening')
        <span class="bg-pink-100 text-pink-700 px-2 py-1 rounded-full text-xs">Evening</span>

    @elseif($slot == 'night')
        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full text-xs">Night</span>

    @elseif($slot == 'late_night')
        <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-xs">Late Night</span>
    @endif
</td>

    <td class="p-2 text-center">
    @if($load->priority == 'high')
        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">
            High
        </span>

    @elseif($load->priority == 'normal')
        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">
            Normal
        </span>

    @elseif($load->priority == 'low')
        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs font-semibold">
            Low
        </span>
    @endif
</td>

    <td class="p-2 text-center">
        @if($load->status == 'pending')
            <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">Pending</span>
        @elseif($load->status == 'assigned')
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">Assigned</span>
        @elseif($load->status == 'expired')
    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Expired</span>
@endif
    </td>

    <td class="p-2 text-center">
        {{ $load->notes ?? '-' }}
    </td>

    <td class="p-2 text-center">
        <a href="{{ route('loads.edit', $load->id) }}" class="text-blue-500">Edit</a>
    </td>
</tr>

    </tr>
    @endforeach
</table>

@endsection