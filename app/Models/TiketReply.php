<?php

namespace App\Models;

use App\Services\BrevoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TiketReply extends Model
{
    use HasFactory;

    protected $table = 'tikets_reply';

    protected $fillable = ['tiket_id', 'message'];

    protected $appends = ['user_str', 'date_humans'];
    protected $hidden = ['user'];
    protected $casts = ['created_at' => 'datetime'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->user_id = auth()->user()->id;
        });

        static::created(function ($obj) {
            $brevo = new BrevoService();
            $user = $obj->tiket()->with('user')->first();
            $params = [
                'email' => $user->email,
                'name' => $user->full_name,
                'url' => sprintf('%s/auth/profile#%s', env('APP_URL'), base64_encode('notifications-ContactAdmin-' . $obj->id))
            ];
            //$brevo->sendEmail('AVISO – contestar MENSAJE FORMULARIO CONTACTAR', 'admin.contact', $params);
        });
    }

    public function tiket()
    {
        return $this->belongsTo(ContactAdmin::class, 'tiket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserStrAttribute()
    {
        return $this->user->full_name;
    }

    public function getDateHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
