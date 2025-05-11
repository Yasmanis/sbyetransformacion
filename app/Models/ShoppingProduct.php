<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingProduct extends Model
{
    use HasFactory;

    protected $table = 'shopping_products';

    protected $fillable = ['total', 'amount'];

    public function shopping()
    {
        return $this->belongsTo(Shopping::class, 'shopping_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
