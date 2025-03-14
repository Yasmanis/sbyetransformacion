<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordChangeNotification extends Model
{
    use HasFactory;

    protected $table = 'password_change_notification';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}