<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushMessageFixedUser extends Model
{
    protected $table = 'push_messages_fixed_users';

    protected $fillable = ['user_id', 'message_id', 'fixed'];

    public $timestamps = false;

    protected $casts = [
        'fixed' => 'boolean'
    ];
}
