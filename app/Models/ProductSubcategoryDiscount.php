<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function getStartAtAttribute($val)
    {
        return Carbon::createFromFormat('Y-m-d', $val)->format('d/m/Y');
    }

    public function getEndAtAttribute($val)
    {
        return $val ? Carbon::createFromFormat('Y-m-d', $val)->format('d/m/Y') : null;
    }
}
