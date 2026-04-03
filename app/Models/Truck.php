<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
   protected $fillable = [
    'truck_code',
    'registration_number',
    'truck_type_id',
    'capacity',
    'ownership_type',
    'status',
    'driver_id',

    // ✅ ADD THESE
    'current_location',
    'current_lat',
    'current_lng'
];
public function type()
{
    return $this->belongsTo(TruckType::class, 'truck_type_id');
}
public function driver()
{
    return $this->belongsTo(\App\Models\Driver::class);
}
}

