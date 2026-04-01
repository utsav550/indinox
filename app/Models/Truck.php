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
    'status'
];
public function type()
{
    return $this->belongsTo(TruckType::class, 'truck_type_id');
}
}

