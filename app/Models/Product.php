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
        'total',
        'first_payment',
        'total_payments',
        'description',
        'image'
    ];

    protected $appends = [
        'image_path'
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
}