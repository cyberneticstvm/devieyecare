<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampDetail extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['registration_date' => 'datetime'];

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }
}
