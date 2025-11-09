<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_category';

    protected $fillable = ['name', 'image', 'description'];

    protected $appends = ['image_path', 'type'];

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

    public function subtitles(): MorphMany
    {
        return $this->morphMany(Subtitle::class, 'subtitlable');
    }

    public function getTypeAttribute()
    {
        return $this::class;
    }

    public function getImagePathAttribute()
    {
        return isset($this->image) ? Storage::url($this->image) : null;
    }
}
