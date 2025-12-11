<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pharmacy extends Model
{
    use SoftDeletes;

    protected $guarded = [];

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

    public function details()
    {
        return $this->hasMany(PharmacyDetail::class, 'pharmacy_id', 'id');
    }

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }
}
