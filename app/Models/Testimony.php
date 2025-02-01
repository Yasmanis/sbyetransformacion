<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'message', 'type', 'user_id', 'publicated', 'name_to_show', 'anonimous', 'msg_to_admin', 'amazon_image'];

    protected $casts = [
        'publicated' => 'boolean',
        'anonimous' => 'boolean'
    ];

    protected $appends = [
        'user_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOwner($query)
    {
        $user = auth()->user();
        return $user->sa ? $query : $query->where('user_id', $user->id);
    }

    public function scopeActive($query)
    {
        return $query->where('publicated', true);
    }

    public function getUserNameAttribute()
    {
        return $this->user->full_name;
    }
}
