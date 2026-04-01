@extends('layout')

@section('content')

<h1 class="text-2xl font-bold mb-4">Dashboard</h1>

<div class="grid grid-cols-4 gap-4">
    <div class="bg-white p-4 shadow">Total Loads: {{ $totalLoads }}</div>
    <div class="bg-white p-4 shadow">Delivered: {{ $deliveredLoads }}</div>
    <div class="bg-white p-4 shadow">Pending: {{ $pendingLoads }}</div>
    <div class="bg-white p-4 shadow">Revenue: ₹{{ $totalRevenue }}</div>
    <div class="bg-white p-4 shadow">Total Expense: ₹{{ $totalExpense }}</div>
    <div class="bg-white p-4 shadow">Total Profit: ₹{{ $totalProfit }}</div>
    

<div class="bg-white p-4 shadow rounded">
    <h2 class="text-xl font-bold mb-4 center">Driver Profits</h2>
    @foreach($driverProfits as $data)
        <div class="flex justify-between border-b py-2">
            <span>{{ $data['driver'] }}</span>

            <span class="
                {{ $data['profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}
            ">
                ₹{{ $data['profit'] }}
            </span>
        </div>
    @endforeach
</div>
</div>

@endsection
