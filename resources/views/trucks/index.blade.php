@extends('layout')

@section('content')

<h2 class="text-xl font-bold mb-4">Trucks</h2>

<a href="{{ route('trucks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
    Add Truck
</a>

<table class="w-full mt-4 bg-white shadow">
    <tr class="bg-gray-200 text-left">
    <th class="p-2">Truck Code</th>
    <th class="p-2">Registration</th>
    <th class="p-2">Type</th>
    <th class="p-2">Capacity</th>
    <th class="p-2">Ownership</th>
    <th class="p-2">Status</th>
    <th class="p-2">Action</th>
</tr>

    @foreach($trucks as $truck)
   <tr class="border-t">
    <td class="p-2">{{ $truck->truck_code }}</td>
    <td class="p-2">{{ $truck->registration_number }}</td>
    <td class="p-2">{{ $truck->type->name ?? '' }}</td>
    <td class="p-2">{{ $truck->capacity }}</td>
    <td class="p-2 capitalize">
        {{ str_replace('_', ' ', $truck->ownership_type) }}
    </td>

    <td class="p-2">
        @if($truck->status == 'active')
            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Active</span>
        @elseif($truck->status == 'in_service')
            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">In Service</span>
        @elseif($truck->status == 'inoperative')
            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Inoperative</span>
        @elseif($truck->status == 'on_hold')
            <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">On Hold</span>
        @endif
    </td>
    <td class="p-2">
    <a href="{{ route('trucks.edit', $truck->id) }}" class="text-blue-500">
        Edit
    </a>
</td>
</tr>
    @endforeach

</table>

@endsection