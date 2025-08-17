<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    protected $table = 'products_offers';

    protected $fillable = [
        'price',
        'start_at',
        'end_at',
        'product_id'
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
        return Carbon::createFromFormat('Y-m-d', $val)->format('d/m/Y');
    }
}
