<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        'information_to_landing',
        'planes'
    ];

    protected $appends = [
        'image_path',
        'categories_id',
        'categories_str',
        'active_offers',
        'final_price'
    ];

    protected $with = ['subtitles'];

    protected $casts = [
        'public' => 'boolean',
        'clients_valoration' => 'boolean',
        'information_to_landing' => 'boolean',
        'planes' => 'json'
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

    public function offers()
    {
        return $this->hasMany(ProductOffer::class, 'product_id');
    }

    public function discounts()
    {
        return $this->hasMany(ProductDiscount::class, 'product_id');
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

    public function getActiveOffersAttribute()
    {
        $offers = DB::select("select id, price, DATE_FORMAT(start_at,'%d/%m/%Y') start_at, DATE_FORMAT(end_at,'%d/%m/%Y') end_at, description from products_offers where product_id=? and ((start_at <= CURDATE() AND end_at IS NULL) or (CURDATE() BETWEEN start_at AND end_at))", [$this->id]);
        $discounts = DB::select("select id, code, percent, income, DATE_FORMAT(start_at,'%d/%m/%Y') start_at, DATE_FORMAT(end_at,'%d/%m/%Y') end_at, description from products_discount where product_id=? and ((start_at <= CURDATE() AND end_at IS NULL) or (CURDATE() BETWEEN start_at AND end_at))", [$this->id]);
        return [
            'offer' => count($offers) > 0 ? $offers[0] : null,
            'discount' => count($discounts) > 0 ? $discounts[0] : null
        ];
    }

    public function getFinalPriceAttribute()
    {
        $price = $this->price;
        $offers = $this->active_offers;
        if (isset($offers['offer'])) {
            $price = $offers['offer']->price;
        }
        if (isset($offers['discount'])) {
            $price = $price - $offers['discount']->income;
        }
        return $price;
    }
}
