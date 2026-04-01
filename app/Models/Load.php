<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer; // 👈 IMPORTANT
use App\Models\Driver; // 👈 make sure this is at top
use App\Models\Truck;

class Load extends Model
{
  protected $fillable = [
    'customer_id',
    'pickup_location',
    'delivery_location',
    'material',
    'weight',
    'pickup_date',
    'pickup_time_slot',
    'price',
    'truck_type_required_id',
    'priority',
    'trip_days',
    'notes',
    'status'

];
public function truckType()
{
    return $this->belongsTo(\App\Models\TruckType::class, 'truck_type_required_id');
}
public function driver()
{
    return $this->belongsTo(Driver::class);
}
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    

public function truck()
{
    return $this->belongsTo(Truck::class);
}

}