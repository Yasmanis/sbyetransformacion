<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SchoolResource extends Model
{
    protected $appends = ['video', 'total_time', 'current_time', 'percent'];

    protected $casts = [
        'principal' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function getVideoAttribute()
    {
        return Str::startsWith($this->type, 'video/');
    }

    public function getPercentAttribute()
    {
        $percent = SchoolUserVideo::where('user_id', auth()->user()->id)->where('resource_id', $this->id)->first();
        return $percent != null ? $percent->percent : 0;
    }
    public function getTotalTimeAttribute()
    {
        $time = SchoolUserVideo::where('user_id', auth()->user()->id)->where('resource_id', $this->id)->first();
        return $time != null ? $time->total_time : 0;
    }

    public function getCurrentTimeAttribute()
    {
        $time = SchoolUserVideo::where('user_id', auth()->user()->id)->where('resource_id', $this->id)->first();
        return $time != null ? $time->current_time : 0;
    }

    public function topic()
    {
        return $this->belongsTo(SchoolTopic::class);
    }
    public function users()
    {
        return $this->hasMany(SchoolUserVideo::class, 'resource_id');
    }
}
