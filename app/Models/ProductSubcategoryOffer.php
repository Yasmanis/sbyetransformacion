<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubcategoryOffer extends Model
{
    protected $table = 'products_offers_subcategory';

    protected $fillable = [
        'price',
        'start_at',
        'end_at',
        'subcategory_id',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id');
    }
}
