<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['rdate' => 'datetime', 'post_review_date' => 'datetime'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function getAge()
    {
        return $this->age + Carbon::parse($this->created_at)->age;
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'registration_id', 'id');
    }

    public function pharmacy()
    {
        return $this->hasMany(Pharmacy::class, 'registration_id', 'id');
    }

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function getMrn()
    {
        return 'MRN/' . $this->mrn . '/' . $this->branch()->value('code');
    }
}
