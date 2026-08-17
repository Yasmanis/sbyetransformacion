<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubcategoryDiscount extends Model
{
    protected $table = 'products_discount_subcategory';

    protected $fillable = [
        'code',
        'percent',
        'income',
        'start_at',
        'end_at',
        'subcategory_id',
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
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id');
    }
}
