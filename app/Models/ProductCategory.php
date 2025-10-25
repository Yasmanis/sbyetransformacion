<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_category';

    protected $fillable = ['name', 'description'];

    protected $appends = ['type'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function subtitles(): MorphMany
    {
        return $this->morphMany(Subtitle::class, 'subtitlable');
    }

    public function getTypeAttribute()
    {
        return $this::class;
    }
}
