<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'message', 'type', 'user_id', 'publicated'];

    protected $casts = [
        'publicated' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}