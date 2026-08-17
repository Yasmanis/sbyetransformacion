<?php

namespace App\Models;

use App\Traits\Recyclable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory, Recyclable;

    protected $table = 'file';

    protected $fillable = ['name', 'size', 'path', 'type', 'category_id', 'public_access', 'public_date', 'poster', 'link', 'fixed'];

    protected $appends = ['category', 'size_str', 'file', 'is_after', 'file_type'];

    protected $casts = [
        'public_access' => 'boolean',
        'fixed' => 'boolean',
        'public_date' => 'date'
    ];

    protected static function booted()
    {
        static::deleting(function ($obj) {
            $obj->deleteFileFromDisk();
        });
        static::created(function ($obj) {
            if ($obj->public_date) {
                $obj->public_access = true;
                $obj->save();
            } else if ($obj->public_access) {
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

    public function getFileAttribute()
    {
        return $this->path;
    }

    public function getFileTypeAttribute()
    {
        return Str::before($this->type, '/');
    }

    public function getIsAfterAttribute()
    {
        $date = $this->public_date;
        if (!isset($date)) {
            return false;
        }
        return Carbon::parse($date)->gt(now());
    }

    public function scopeTypeOfFile($query, $args)
    {
        return $query->where('type', 'like', $args[0] . '%');
    }

    public function scopePublicAccess($query)
    {
        return $query->where('public_access', true)->whereDate('public_date', '<=', Carbon::today())->whereHas('category', function (Builder $query) {
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
