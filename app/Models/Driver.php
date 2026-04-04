<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'license_number',
        'status',
        'driver_type',
        'admin_notes',
        'applied_at',
    ];

    public function truck()
    {
        return $this->hasOne(\App\Models\Truck::class);
    }
}