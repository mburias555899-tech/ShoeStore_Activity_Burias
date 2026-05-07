<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $fillable = [
        'order_id',
        'amount_paid',
        'remaining_balance',
        'payment_status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
