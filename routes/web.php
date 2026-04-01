<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\DispatchController;

Route::resource('drivers', DriverController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('customers', CustomerController::class);
Route::post('/loads/{id}/status', [LoadController::class, 'updateStatus'])->name('loads.updateStatus');
Route::resource('loads', LoadController::class);
Route::resource('trucks', TruckController::class);
Route::get('/dispatch', [DispatchController::class, 'index'])->name('dispatch.index');
Route::post('/dispatch/assign', [DispatchController::class, 'assign'])->name('dispatch.assign');
Route::post('/dispatch/assign', [DispatchController::class, 'assign'])->name('dispatch.assign');
Route::get('/', function () {
    return redirect('/customers');
});