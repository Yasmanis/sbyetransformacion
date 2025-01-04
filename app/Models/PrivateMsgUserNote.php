<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMsgUserNote extends Model
{
    protected $table = 'private_msg_notes';
    public $timestamps = false;

    public function message()
    {
        return $this->belongsTo(PrivateMsg::class, 'message_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
