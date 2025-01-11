<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $table = 'file';

    protected $fillable = ['name', 'size', 'path', 'type', 'category_id', 'public_access'];

    protected $appends = ['category', 'size_str'];

    protected $casts = [
        'public_access' => 'boolean',
    ];

    protected static function booted()
    {
        static::deleting(function ($obj) {
            $obj->deleteFileFromDisk();
        });
        static::created(function ($obj) {
            if ($obj->public_access) {
                $obj->public_date = $obj->created_at;
                $obj->save();
            }
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

    public function getPublicDateAttribute($v)
    {
        return isset($v) ? Carbon::parse($v)->format('d/m/Y') : null;
    }

    public function scopeTypeOfFile($query, $args)
    {
        return $query->where('type', 'like', $args[0] . '%');
    }

    public function scopePublicAccess($query)
    {
        return $query->where('public_access', true)->whereHas('category', function (Builder $query) {
            $query->where('public_access', true);
        });
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
