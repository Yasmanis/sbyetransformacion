<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Landing extends Model
{
    protected $table = 'landings';

    protected $fillable = [
        'url',
        'image',
        'logo',
        'text',
        'product_id'
    ];

    protected $appends = [
        'image_path',
        'product_str'
    ];

    protected $casts = ['logo' => 'boolean'];

    protected static function booted()
    {
        static::deleting(function ($obj) {
            $obj->deleteFileFromDisk();
        });
    }

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }

    public function getImagePathAttribute()
    {
        return isset($this->image) ? Storage::url($this->image) : null;
    }

    public function getProductStrAttribute()
    {
        $product = $this->product;
        return $product ? $product->name : null;
    }

    public function deleteFileFromDisk()
    {
        Storage::delete('public/' . $this->image);
    }
}
