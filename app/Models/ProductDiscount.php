<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'description'
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
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
