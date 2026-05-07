<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'shoe_product_id',
        'quantity',
        'total_cost',
        'status',
        'order_date',
    ];

    public function shoeProduct()
    {
        return $this->belongsTo(ShoeProduct::class);
    }
}