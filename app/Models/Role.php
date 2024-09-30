<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = ['name'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->guard_name = $attributes['guard_name'] ?? config('auth.defaults.guard');
        });
    }
}
