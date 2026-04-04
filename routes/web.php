<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\DispatchController;

// ✅ JOIN ROUTES — must be before resource route
Route::get('/join',         [DriverController::class, 'joinForm'])->name('drivers.join');
Route::post('/join',        [DriverController::class, 'joinStore'])->name('drivers.join.store');
Route::get('/join/success', [DriverController::class, 'joinSuccess'])->name('drivers.join.success');

// ✅ DRIVER MANAGEMENT ROUTES — before resource
Route::post('/drivers/{id}/approve',       [DriverController::class, 'approve'])->name('drivers.approve');
Route::post('/drivers/{id}/reject',        [DriverController::class, 'reject'])->name('drivers.reject');
Route::post('/drivers/{id}/update-status', [DriverController::class, 'updateStatus'])->name('drivers.updateStatus');

// RESOURCE ROUTES
Route::resource('drivers', DriverController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('customers', CustomerController::class);
Route::post('/loads/{id}/status', [LoadController::class, 'updateStatus'])->name('loads.updateStatus');
Route::resource('loads', LoadController::class);
Route::resource('trucks', TruckController::class);
Route::get('/dispatch',              [DispatchController::class, 'index'])->name('dispatch.index');
Route::post('/dispatch/{id}',        [DispatchController::class, 'assign'])->name('dispatch.assign');
Route::post('/dispatch/unassign/{id}', [DispatchController::class, 'unassign'])->name('dispatch.unassign');

Route::get('/', function () {
    return redirect('/dashboard');
});