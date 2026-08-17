<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryDiscount extends Model
{
    protected $table = 'products_discount_category';

    protected $fillable = [
        'code',
        'percent',
        'income',
        'start_at',
        'end_at',
        'category_id',
        'description',
        'offers_income',
        'active'
    ];

    protected $casts = [
        'offers_income' => 'boolean',
        'active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
