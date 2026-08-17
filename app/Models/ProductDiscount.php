<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $table = 'products_discount';

    protected $fillable = [
        'code',
        'percent',
        'income',
        'start_at',
        'end_at',
        'product_id',
        'description',
        'offers_income',
        'active'
    ];

    protected $casts = [
        'offers_income' => 'boolean',
        'active' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
