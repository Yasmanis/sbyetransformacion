<?php

namespace App\Models;

use App\Services\BrevoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactAdmin extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'description'];

    protected $with = ['responses', 'attachments'];

    protected $appends = ['user_str', 'date_humans', 'send'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->created_by = auth()->user()->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function responses()
    {
        return $this->hasMany(ContactAdmin::class, 'root_parent_id');
    }

    public function attachments()
    {
        return $this->hasMany(ContactAdminAttachment::class, 'contact_id');
    }

    public function setMessage()
    {
        $brevo = new BrevoService();
        $user = $this->user()->first();
        $params = [
            'email' => $user->email,
            'name' => $user->full_name,
            'url' => sprintf('%s/auth/profile#%s', env('APP_URL'), base64_encode(json_encode(
                [
                    'tab' => 'notifications',
                    'model' => ContactAdmin::class,
                    'id' => $this->id
                ]
            )))
        ];
        return $brevo->sendEmail('AVISO – contestar MENSAJE FORMULARIO CONTACTAR', 'admin.contact', $params);
    }

    public function getDateHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUserStrAttribute()
    {
        return $this->user()->first()->full_name;
    }

    public function getSendAttribute()
    {
        return auth()->user()->id === $this->created_by;
    }
}
