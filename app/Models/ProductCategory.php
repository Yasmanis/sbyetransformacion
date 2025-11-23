<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_category';

    protected $fillable = ['name', 'image', 'description', 'end_text'];

    protected $appends = ['image_path', 'active_offer', 'active_discount', 'type'];

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

    public function subcategories()
    {
        return $this->hasMany(ProductSubcategory::class, 'category_id')->orderBy('order', 'asc');
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

    public function getActiveOfferAttribute()
    {
        $offers = DB::select("select id, price, DATE_FORMAT(start_at,'%d/%m/%Y') start_at, DATE_FORMAT(end_at,'%d/%m/%Y') end_at, description from products_offers_category where category_id=? and active=1 and ((start_at <= CURDATE() AND end_at IS NULL) or (CURDATE() BETWEEN start_at AND end_at))", [$this->id]);
        return count($offers) > 0 ? $offers[0] : null;
    }

    public function getActiveDiscountAttribute()
    {
        $discounts = DB::select("select id, code, percent, income, DATE_FORMAT(start_at,'%d/%m/%Y') start_at, DATE_FORMAT(end_at,'%d/%m/%Y') end_at, description, offers_income from products_discount_category where category_id=? and active=1 and ((start_at <= CURDATE() AND end_at IS NULL) or (CURDATE() BETWEEN start_at AND end_at))", [$this->id]);
        return count($discounts) > 0 ? $discounts[0] : null;
    }
}
