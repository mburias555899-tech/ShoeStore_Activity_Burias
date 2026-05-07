<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'shoe_product_id',
        'quantity',
        'total_cost',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shoeProduct()
    {
        return $this->belongsTo(ShoeProduct::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
