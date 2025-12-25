<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeExpense extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['ie_date' => 'datetime'];

    public function cancelled()
    {
        return $this->deleted_at ? "<span class='badge bg-danger'>Cancelled</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function head()
    {
        return $this->belongsTo(Head::class, 'head_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }


    public function category()
    {
        return $this->belongsTo(Extra::class, 'category_id', 'id');
    }
}
