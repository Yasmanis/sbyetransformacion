<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class SchoolTopic extends Model
{
    protected $fillable = ['name', 'coverImage', 'description', 'section_id', 'book_volume', 'visible_after_testimony'];
    protected $appends = [
        'duration_string',
        'percent',
        'has_resources',
        'has_principal_video',
        'has_access'
    ];

    protected $casts = [
        'visible_after_testimony' => 'boolean'
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
        $principal = $this->resources()->where('type', 'like', 'video/%')->where('principal', true)->first();
        if ($principal != null) {
            $percent = SchoolUserVideo::where('user_id', auth()->user()->id)->where('resource_id', $principal->id)->first();
            return $percent != null ? $percent->percent : 0;
        }
        return 100;
    }

    public function getHasResourcesAttribute()
    {
        $resources = $this->resources()->where('principal', false)->first();
        return $resources != null;
    }

    public function getHasAccessAttribute()
    {
        $user = auth()->user();
        return $user->has_testimony || $user->sa || !$this->visible_after_testimony;
    }

    public function getHasPrincipalVideoAttribute()
    {
        return $this->resources()->where('principal', true)->first() != null;
    }

    public function section()
    {
        return $this->belongsTo(SchoolSection::class);
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
