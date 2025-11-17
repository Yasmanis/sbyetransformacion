<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
        'planes',
        'category_id',
        'subcategory_id',
        'course_id'
    ];

    protected $appends = [
        'image_path',
        'active_offer',
        'active_discount',
        'offers_or_promo',
        'category_str',
        'subcategory_str',
        'course_str',
        'final_price',
        'type'
    ];

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

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id');
    }

    public function course()
    {
        return $this->belongsTo(Module::class, 'course_id');
    }

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'products_categories', 'product_id', 'category_id');
    }

    public function subtitles(): MorphMany
    {
        return $this->morphMany(Subtitle::class, 'subtitlable');
    }

    public function offers()
    {
        return $this->hasMany(ProductOffer::class, 'product_id');
    }

    public function discounts()
    {
        return $this->hasMany(ProductDiscount::class, 'product_id');
    }

    public function scopePublic($query)
    {
        return $query->where('public', true);
    }

    public function getActiveOfferAttribute()
    {
        $offer = $this->category->active_offer ?? null;
        if (!isset($offer)) {
            $offer = $this->subcategory->active_offer ?? null;
        }
        if (!isset($offer)) {
            $temp = DB::select("select id, price, DATE_FORMAT(start_at,'%d/%m/%Y') start_at, DATE_FORMAT(end_at,'%d/%m/%Y') end_at, description from products_offers where product_id=? and active=1 and ((start_at <= CURDATE() AND end_at IS NULL) or (CURDATE() BETWEEN start_at AND end_at))", [$this->id]);
            $offer = count($temp) > 0 ? $temp[0] : null;
        }
        return $offer;
    }

    public function getActiveDiscountAttribute()
    {
        $discount = $this->category->active_discount ?? null;
        if (!isset($discount)) {
            $discount = $this->subcategory->active_discount ?? null;
        }
        if (!isset($discount)) {
            $temp = DB::select("select id, code, percent, income, DATE_FORMAT(start_at,'%d/%m/%Y') start_at, DATE_FORMAT(end_at,'%d/%m/%Y') end_at, description, offers_income from products_discount where product_id=? and active=1 and ((start_at <= CURDATE() AND end_at IS NULL) or (CURDATE() BETWEEN start_at AND end_at))", [$this->id]);
            $discount = count($temp) > 0 ? $temp[0] : null;
        }
        return $discount;
    }

    public function getOffersOrPromoAttribute()
    {
        return isset($this->active_offer) || isset($this->active_discount);
    }

    public function getFinalPriceAttribute()
    {
        $price = $this->price;
        $offer = $this->active_offer;
        $discount =  $this->active_discount;
        if (isset($offer)) {
            $price = $offer->price;
        }
        if (isset($discount)) {
            $price = $price - (($discount->percent / 100) * $this->price);
        }
        return round($price, 2);
    }

    public function getCategoryStrAttribute()
    {
        return $this->category->name ?? null;
    }

    public function getSubCategoryStrAttribute()
    {
        return $this->subcategory->name ?? null;
    }

    public function getCourseStrAttribute()
    {
        return $this->course->singular_label ?? null;
    }

    public function getTypeAttribute()
    {
        return $this::class;
    }
}
