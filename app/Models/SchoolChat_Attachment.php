<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolChat_Attachment extends Model
{
    protected $table = 'schoolchat_attachments';

    public function chat()
    {
        return $this->belongsTo(SchoolChat::class);
    }
}