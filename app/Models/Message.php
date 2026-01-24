<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['title', 'message', 'importance', 'message_id', 'start_at', 'end_at', 'assigned_to', 'periodicity'];

    protected $appends = ['sections_id', 'sections_str', 'assigned_to_object', 'users_id_object'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'periodicity' => 'json'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $user = auth()->user();
            if ($user) {
                $obj->created_by = $user->id;
            }
        });
        static::updating(function ($obj) {
            $user = auth()->user();
            if ($user) {
                $obj->created_by = $user->id;
            }
        });
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function sections()
    {
        return $this->belongsToMany(CategoryNomenclature::class, 'message_sections', 'message_id', 'section_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'messages_users', 'message_id', 'user_id');
    }

    public function getSectionsIdAttribute()
    {
        $sections = $this->sections()->get();
        return count($sections) > 0 ? $sections->pluck('id') : null;
    }

    public function getSectionsStrAttribute()
    {
        return $this->sections()->get()->implode('value', ', ');
    }

    public function getCreatedAtAttribute($v)
    {
        return isset($v) ? Carbon::parse($v)->format('d/m/Y h:i A') : null;
    }

    public function getNextAttribute($v)
    {
        return isset($v) ? Carbon::parse($v)->format('d/m/Y') : null;
    }

    public function getStartAtAttribute($v)
    {
        return isset($v) ? Carbon::parse($v)->format('d/m/Y h:i A') : null;
    }

    public function getEndAtAttribute($v)
    {
        return isset($v) ? Carbon::parse($v)->format('d/m/Y h:i A') : null;
    }

    public function getAssignedToObjectAttribute()
    {
        $assigned = $this->assigned;
        if (isset($assigned)) {
            return $assigned->only('id', 'full_name');
        }
        return null;
    }

    public function getUsersIdObjectAttribute()
    {
        return $this->users()->get();
    }
}
