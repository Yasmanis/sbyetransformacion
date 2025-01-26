<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotifications extends Model
{
    use HasFactory;

    protected $table = 'users_notifications';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}