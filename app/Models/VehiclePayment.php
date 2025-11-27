<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehiclePayment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['pdate' => 'datetime'];

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}
