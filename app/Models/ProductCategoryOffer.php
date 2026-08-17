<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryOffer extends Model
{
    protected $table = 'products_offers_category';

    protected $fillable = [
        'price',
        'start_at',
        'end_at',
        'category_id',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
