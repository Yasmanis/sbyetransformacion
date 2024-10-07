<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'file';

    protected $fillable = ['name', 'size', 'path', 'type', 'category_id'];

    protected $appends = ['category', 'size_str'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryAttribute()
    {
        return $this->category()->first()->name ?? '';
    }

    public function getSizeStrAttribute()
    {
        $units = ['Bytes', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb'];
        $bytes = $this->size;
        for ($i = 0; $bytes > 1024; $i++)
            $bytes /= 1024;
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
