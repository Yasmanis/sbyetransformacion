<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $table = 'file';

    protected $fillable = ['name', 'size', 'path', 'type', 'category_id'];

    protected $appends = ['category', 'size_str', 'date_for_human'];

    protected static function booted()
    {
        static::deleting(function ($obj) {
            $obj->deleteFileFromDisk();
        });
    }

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

    public function getDateForHumanAttribute()
    {
        return $this->created_at->locale('es')->isoFormat(('MMMM D, Y'));
    }

    public function scopeTypeOfFile($query, $args)
    {
        return $query->where('type', 'like', $args[0] . '%');
    }

    public function deleteFileFromDisk()
    {
        if (isset($this->poster)) {
            Storage::delete('public/' . $this->poster);
        }
        Storage::delete('public/' . $this->path);
    }

    public function deletePosterFromDisk()
    {
        if (isset($this->poster)) {
            Storage::delete('public/' . $this->poster);
        }
    }
}
