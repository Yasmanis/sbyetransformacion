<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateMsgAttachments extends Model
{
    use HasFactory;

    protected $table = 'private_msg_attachments';

    public $timestamps = false;

    public function message()
    {
        return $this->belongsTo(PrivateMsg::class);
    }
}
