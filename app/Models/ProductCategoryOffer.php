<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryOffer extends Model
{
    protected $table = 'products_offers_category';

    protected $fillable = [
        'price',
        'start_at',
        'end_at',
        'category_id',
        'description'
    ];

    public function product()
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
