<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class SchoolTopic extends Model
{
    protected $fillable = ['name', 'coverImage', 'description', 'section_id', 'book_volume', 'visible_after_testimony', 'skip'];
    protected $appends = [
        'duration_string',
        'percent',
        'has_resources',
        'has_principal_video',
        'has_access',
        'has_access_by_volume',
        'has_access_by_full'
    ];

    protected $casts = [
        'visible_after_testimony' => 'boolean',
        'skip' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            if ($obj->description == 'null') {
                $obj->description = null;
            }
        });
    }

    protected static function booted()
    {
        static::deleting(function ($obj) {
            $obj->deleteResourceFromDisk();
        });
    }

    public function getDurationStringAttribute()
    {
        $principal = $this->resources()->where('type', 'like', 'video/%')->where('principal', true)->first();
        return $principal != null ? $principal->duration_string : null;
    }

    public function getPercentAttribute()
    {
        return $this->getPercentByUser(auth()->user());
    }

    public function getPercentByUser($user)
    {
        $principal = $this->resources()->where('principal', true)->first();
        if ($principal != null) {
            $percent = SchoolUserVideo::where('user_id', $user->id)->where('resource_id', $principal->id)->first();
            return $percent != null ? ($percent->last_time / $percent->total_time) * 100  : 0;
        }
        return 0;
    }

    public function getHasResourcesAttribute()
    {
        $resources = $this->resources()->where('principal', false)->first();
        return $resources != null;
    }

    public function getHasAccessAttribute()
    {
        return $this->hasAccessForUser();
    }

    public function hasAccessForUser($user = null)
    {
        $user = $user ?? auth()->user();
        $has_testimony = Testimony::active()->where('user_id', $user->id)->where('book_volume', $this->book_volume)->first();
        return $user->sa ||
            $this->hasFullAccessByUser($user) ||
            $this->hasViewAccessForUser($user) ||
            ($this->hasVolumeAccessForUser($user) && $this->visible_after_testimony && $has_testimony) ||
            ($this->hasVolumeAccessForUser($user) && !$this->visible_after_testimony);
    }

    public function getHasAccessByVolumeAttribute()
    {
        return $this->hasVolumeAccessForUser();
    }

    public function hasVolumeAccessForUser($user = null)
    {
        $user = $user ?? auth()->user();
        $volumes = $user->book_volumes ? $user->book_volumes : [];
        return $user->sa || $this->hasFullAccessByUser($user) || $this->hasViewAccessForUser($user) || in_array($this->book_volume, $volumes);
    }

    public function hasViewAccessForUser($user = null)
    {
        $user = $user ?? auth()->user();
        $current_category = $this->section()->first()->category;
        $categories = ['learning', 'reality', 'conference'];
        return $user->sa || (!$this->visible_after_testimony && in_array($current_category, $categories) && $user->hasPerm('view_' . $current_category));
    }

    public function getHasAccessByFullAttribute()
    {
        return $this->hasFullAccessByUser();
    }

    public function hasFullAccessByUser($user = null)
    {
        $user = $user ?? auth()->user();
        $current_category = $this->section()->first()->category;
        $categories = ['school', 'learning', 'reality'];
        return in_array($current_category, $categories) && ($user->sa || $user->hasPerm('full_' . $current_category));
    }

    public function getHasPrincipalVideoAttribute()
    {
        return $this->resources()->where('principal', true)->first() != null;
    }

    public function section()
    {
        return $this->belongsTo(SchoolSection::class, 'section_id');
    }

    public function resources()
    {
        return $this->hasMany(SchoolResource::class, 'topic_id')->orderBy('principal', 'DESC');
    }

    public function users_views()
    {
        return $this->belongsToMany(User::class);
    }

    public function messages()
    {
        return $this->hasMany(SchoolChat::class, 'topic_id')->send()->orWhere(function (Builder $query) {
            $query->received();
        })->orderBy('id', 'ASC');
    }

    public function deleteResourceFromDisk()
    {
        Storage::delete('public/' . $this->coverImage);
        foreach ($this->resources as $r) {
            Storage::delete('public/' . $r->path);
        }
    }
}
