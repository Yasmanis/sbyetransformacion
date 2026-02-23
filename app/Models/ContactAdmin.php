<?php

namespace App\Models;

use App\Notifications\StandardNotification;
use App\Services\BrevoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Notification;

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
        $notification = new UserNotifications();
        $notification->title = 'ayuda desde contacto';
        $notification->priority = 'Alta';
        $notification->user_id = auth()->user()->id;
        $notification->description = $this->description;
        $notification->code = 'help_from_contact';
        $notification->model = ContactAdmin::class;
        $notification->model_id = $this->id;
        $notification->save();

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
        $users = User::isAdmin()->get();
        Notification::send($users, new StandardNotification($notification, 'AVISO – contestar MENSAJE FORMULARIO CONTACTAR', 'admin.contact', ['database', 'brevo'], $params));
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
        return auth()->user()?->id === $this->created_by ?? false;
    }
}
