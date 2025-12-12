<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['tdate' => 'datetime'];

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id', 'id');
    }

    public function fbranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch', 'id');
    }

    public function tbranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch', 'id');
    }

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }
}
