<?php

namespace App\Models;

use App\Traits\FileSave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

class ContactAdminAttachment extends Model
{
    use FileSave;

    protected $table = 'contact_admin_attachments';

    protected $appends = ['humans_size'];

    public function contact()
    {
        return $this->belongsTo(ContactAdmin::class);
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

    public function getHumansSizeAttribute()
    {
        return $this->formatSize($this->size);
    }
}
