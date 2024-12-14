<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = ['name'];

    protected $casts = [
        'public_access' => 'boolean',
        'private_area' => 'boolean'
    ];

    protected static function booted()
    {
        static::deleting(function ($category) {
            foreach ($category->files as $f) {
                $f->deleteFileFromDisk();
            }
        });
    }

    public function files()
    {
        return $this->hasMany(File::class)->orderBy('order', 'ASC');
    }
}