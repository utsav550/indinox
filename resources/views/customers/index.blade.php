@extends('layout')

@section('content')

<h2 class="text-xl font-bold mb-4">Customers</h2>

<a href="{{ route('customers.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
    Add Customer
</a>

<table class="w-full mt-4 bg-white shadow rounded">
    <tr class="bg-gray-200 text-left">
        <th class="p-2">Name</th>
        <th class="p-2">Phone</th>
        <th class="p-2">Email</th>
        <th class="p-2">Company</th>
        <th class="p-2">Action</th>
    </tr>

    @foreach($customers as $customer)
    <tr class="border-t hover:bg-gray-50">
        <td class="p-2">{{ $customer->name }}</td>
        <td class="p-2">{{ $customer->phone }}</td>
        <td class="p-2">{{ $customer->email }}</td>
        <td class="p-2">{{ $customer->company_name }}</td>
        <td class="p-2">
            <a href="{{ route('customers.edit', $customer->id) }}" class="text-blue-500">Edit</a>
        </td>
    </tr>
    @endforeach

</table>

@endsection