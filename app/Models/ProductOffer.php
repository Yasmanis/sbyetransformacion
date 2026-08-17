<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    protected $table = 'products_offers';

    protected $fillable = [
        'price',
        'start_at',
        'end_at',
        'product_id',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
