<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camp extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['from_date' => 'datetime', 'to_date' => 'datetime'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function getCampName()
    {
        return 'CAMP/' . $this->id . '/' . $this->branch()->value('code');
    }

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function details()
    {
        return $this->hasMany(Camp::class, 'camp_id', 'id');
    }
}
