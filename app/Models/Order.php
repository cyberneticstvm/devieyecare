<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['due_date' => 'datetime', 'invoice_generated_at' => 'datetime'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_id', 'id');
    }

    public function ino()
    {
        return ($this->invoice_number) ? $this->invoice_number . '/' . $this->branch()->value('code') . '/' . getCurrentFinancialYear() : '';
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'product_advisor', 'id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id', 'id');
    }

    public function ostatus()
    {
        return $this->belongsTo(Extra::class, 'status', 'id');
    }

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }
}
