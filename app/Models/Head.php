<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Head extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function category()
    {
        return $this->belongsTo(Extra::class, 'category_id', 'id');
    }
}
