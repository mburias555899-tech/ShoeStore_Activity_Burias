<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoeProduct extends Model
{
    use HasFactory;

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

    // Relationship
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}