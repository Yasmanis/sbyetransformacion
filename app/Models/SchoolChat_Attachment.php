<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SchoolChat_Attachment extends Model
{
    protected $table = 'schoolchat_attachments';

    public function chat()
    {
        return $this->belongsTo(SchoolChat::class);
    }

    protected static function booted()
    {
        static::deleting(function ($obj) {
            $obj->deleteFileFromDisk();
        });
    }

    public function deleteFileFromDisk()
    {
        Storage::delete('public/' . $this->path);
    }
}