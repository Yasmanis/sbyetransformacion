<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolTopic extends Model
{
    protected $fillable = ['name', 'coverImage', 'description', 'section_id'];
    protected $appends = ['duration_string', 'percent', 'has_resources'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            if ($obj->description == 'null') {
                $obj->description = null;
            }
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
}