<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class ProductSubcategory extends Model
{
    use HasFactory;

    protected $table = 'product_subcategory';

    protected $fillable = ['name', 'image', 'category_id', 'description'];

    protected $appends = ['image_path', 'category_str', 'type'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($obj) {
            if (isset($obj->image)) {
                Storage::delete('public/' . $obj->image);
            }
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function subtitles(): MorphMany
    {
        return $this->morphMany(Subtitle::class, 'subtitlable');
    }

    public function getTypeAttribute()
    {
        return $this::class;
    }

    public function getCategoryStrAttribute()
    {
        return $this->category->name;
    }

    public function getImagePathAttribute()
    {
        return isset($this->image) ? Storage::url($this->image) : null;
    }
}
