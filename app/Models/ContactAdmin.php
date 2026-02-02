<?php

namespace App\Models;

use App\Services\BrevoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactAdmin extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'description'];

    protected $with = ['tikets'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->created_by = auth()->user()->id;
        });

        static::created(function ($obj) {
            $brevo = new BrevoService();
            $user = $obj->user()->first();
            $params = [
                'email' => $user->email,
                'name' => $user->full_name,
                'url' => sprintf('%s/auth/profile#%s', env('APP_URL'), base64_encode(json_encode(
                    [
                        'tab' => 'notifications',
                        'model' => ContactAdmin::class,
                        'id' => $obj->id
                    ]
                )))
            ];
            $brevo->sendEmail('AVISO – contestar MENSAJE FORMULARIO CONTACTAR', 'admin.contact', $params);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tikets()
    {
        return $this->hasMany(TiketReply::class, 'tiket_id');
    }
}
