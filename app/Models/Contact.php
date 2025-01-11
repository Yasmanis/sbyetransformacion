<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['book_number', 'book_date', 'msg_title', 'message', 'other_people', 'user_id', 'ticket'];

    protected $appends = ['book_volume_img'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'contact_id');
    }

    public function getBookVolumeImgAttribute()
    {
        if ($this->book_volume) {
            if ($this->book_volume == 'tomo_1') return 'images/books/book-1.png';
            else if ($this->book_volume == 'tomo_1') return 'images/books/book-2.png';
            else return 'images/books/book-3.png';
        }
        return 'images/icon/emoji-duda.jpg';
    }

    public function getBookDateAttribute($v)
    {
        return isset($v) ? Carbon::parse($v)->format('d/m/Y') : null;
    }
}
