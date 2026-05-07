<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoeProduct extends Model
{
    protected $fillable = [
        'product_name',
        'brand',
        'category',
        'size',
        'color',
        'stock_quantity',
        'price',
        'description',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}