<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function payments()
    {
        return $this->hasMany(VehiclePayment::class, 'payment_id', 'id');
    }
}
