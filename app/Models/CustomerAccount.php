<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAccount extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pmode()
    {
        return $this->belongsTo(Extra::class, 'payment_mode');
    }

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }
}
