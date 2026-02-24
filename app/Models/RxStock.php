<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RxStock extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id')->withTrashed();
    }

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }
}
