<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushMessageConfigNotification extends Model
{
    protected $table = 'push_messages_config_notification';

    protected $fillable = ['user_id', 'message_id', 'data'];

    public $timestamps = false;

    protected $casts = [
        'data' => 'json'
    ];
}