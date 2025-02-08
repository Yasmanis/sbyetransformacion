<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BriefIdea extends Model
{
    protected $table = 'brief_ideas';

    protected $fillable = ['title', 'message'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->created_by = auth()->user()->id;
        });
    }

    public function getCreatedByAttribute($val)
    {
        $user = User::find($val);
        return $user != null ? $user->full_name : null;
    }
}
