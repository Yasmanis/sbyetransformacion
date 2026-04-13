<?php

namespace App\Models;

use App\Traits\Recyclable;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use Recyclable;

    protected $fillable = ['name'];

    protected $appends = ['permissions'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->guard_name = $attributes['guard_name'] ?? config('auth.defaults.guard');
        });
    }

    public function getPermissionsAttribute()
    {
        return $this->permissions()->get()->pluck('id');
    }
}
