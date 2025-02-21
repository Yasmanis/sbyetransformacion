<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Arrays;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['book_date', 'msg_title', 'message', 'other_people', 'user_id', 'ticket'];

    protected $appends = ['book_volume_img'];

    protected $casts = [
        'book_volumes' => 'json'
    ];

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
        $book_volumes = $this->book_volumes;
        if ($book_volumes) {
            if (Arrays::contains($book_volumes, 'tomo_1')) return 'images/books/book-1.png';
            else if (Arrays::contains($book_volumes, 'tomo_2')) return 'images/books/book-2.png';
            else return 'images/books/book-3.png';
        }
        return 'images/icon/emoji-duda.jpg';
    }

    public function getBookDateAttribute($v)
    {
        return isset($v) ? Carbon::parse($v)->format('d/m/Y') : null;
    }
}
