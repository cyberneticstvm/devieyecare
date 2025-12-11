<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo(Extra::class, 'status_id', 'id');
    }
}
