<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\LoadService;

LoadService::updateExpired();

class Dispatch extends Model
{
    //
    protected $fillable = [
    'load_id',
    'truck_id',
    'driver_id',
    'assigned_date',
    'start_date',
    'end_date'
];
}
