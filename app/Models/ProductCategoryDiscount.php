<?php

namespace App\Models;

use Carbon\Carbon;
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
        'offers_income'
    ];

    protected $casts = [
        'offers_income' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function getStartAtAttribute($val)
    {
        return Carbon::createFromFormat('Y-m-d', $val)->format('d/m/Y');
    }

    public function getEndAtAttribute($val)
    {
        return $val ? Carbon::createFromFormat('Y-m-d', $val)->format('d/m/Y') : null;
    }
}
