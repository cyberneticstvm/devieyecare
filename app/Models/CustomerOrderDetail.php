<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerOrderDetail extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(CustomerOrder::class, 'customer_order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
