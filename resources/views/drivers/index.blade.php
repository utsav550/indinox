@extends('layout')

@section('content')

<h2 class="text-xl font-bold mb-4">Drivers</h2>

<a href="{{ route('drivers.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
    Add Driver
</a>

<table class="w-full mt-4 bg-white shadow rounded">
    <tr class="bg-gray-200 text-left">
        <th class="p-2">Name</th>
        <th class="p-2">Phone</th>
        <th class="p-2">License</th>
        <th class="p-2">Action</th>
    </tr>

    @foreach($drivers as $driver)
    <tr class="border-t hover:bg-gray-50">
        <td class="p-2">{{ $driver->name }}</td>
        <td class="p-2">{{ $driver->phone }}</td>
        <td class="p-2">{{ $driver->license_number }}</td>
        <td class="p-2">
            <!-- Future edit option -->
            <span class="text-gray-400 text-sm">-</span>
        </td>
    </tr>
    @endforeach

</table>

@endsection