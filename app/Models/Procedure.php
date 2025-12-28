<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procedure extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function medicines()
    {
        return $this->hasMany(ProcedureMedicine::class, 'procedure_id', 'id');
    }
}
