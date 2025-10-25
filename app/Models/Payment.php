<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'payment_id',
        'status',
        'amount',
        'currency',
        'payload'
    ];

    protected $casts = [
        'payload' => 'array'
    ];

    public function products()
    {
        return $this->belongsToMany(PaymentProduct::class);
    }
}
