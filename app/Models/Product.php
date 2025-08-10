<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'id',
        'name',
        'price',
        'description',
        'image',
        'public',
        'valoration',
        'clients_valoration',
        'information_to_landing'
    ];

    protected $appends = [
        'image_path',
        'categories_id',
        'categories_str'
    ];

    protected $with = ['subtitles'];

    protected $casts = [
        'public' => 'boolean',
        'clients_valoration' => 'boolean',
        'information_to_landing' => 'boolean'
    ];

    protected static function booted()
    {
        static::deleting(function ($obj) {
            $obj->deleteFileFromDisk();
        });
    }

    public function getImagePathAttribute()
    {
        return isset($this->image) ? Storage::url($this->image) : null;
    }

    public function deleteFileFromDisk()
    {
        Storage::delete('public/' . $this->image);
    }

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'products_categories', 'product_id', 'category_id');
    }

    public function subtitles()
    {
        return $this->hasMany(ProductSubtitle::class, 'product_id');
    }

    public function getCategoriesIdAttribute()
    {
        return $this->categories()->get()->pluck('id');
    }

    public function getCategoriesStrAttribute()
    {
        return $this->categories()->get()->pluck('name');
    }

    public function scopePublic($query)
    {
        return $query->where('public', true);
    }
}
