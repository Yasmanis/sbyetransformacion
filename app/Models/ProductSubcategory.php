<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubcategory extends Model
{
    use HasFactory;

    protected $table = 'product_subcategory';

    protected $fillable = ['name', 'category_id'];

    protected $appends = ['category_str'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function getCategoryStrAttribute()
    {
        return $this->category->name;
    }
}
