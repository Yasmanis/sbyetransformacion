<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductSubtitle extends Model
{
    protected $table = 'products_subtitles';

    protected $fillable = [
        'name',
        'description',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
