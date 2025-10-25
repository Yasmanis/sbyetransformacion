<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentProduct extends Model
{
    protected $table = 'payment_products';

    protected $fillable = [
        'payment_id',
        'product_id',
        'amount',
    ];

    protected $casts = [
        'payload' => 'array'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
