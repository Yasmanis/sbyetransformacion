<?php

namespace App\Models;

use App\Notifications\StandardNotification;
use App\Traits\Recyclable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Notification;

class Testimony extends File
{
    use HasFactory, Recyclable;

    protected $fillable = ['name', 'path', 'message', 'type', 'user_id', 'publicated', 'name_to_show', 'anonimous', 'msg_to_admin', 'amazon_image', 'order', 'book_volume'];

    protected $casts = [
        'publicated' => 'boolean',
        'anonimous' => 'boolean'
    ];

    protected $appends = [
        'user_name',
        'volumes',
        'file_type'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($obj) {
            $category = Category::firstWhere('name', 'testimonios');
            $obj->category_id = $category->id;
        });

        static::created(function ($obj) {

            $notification = new UserNotifications();
            $notification->title = 'nuevo testimonio';
            $notification->priority = 'Alta';
            $notification->user_id = auth()->user()->id;
            $notification->description = $obj->title;
            $notification->code = 'testimony';
            $notification->model = Testimony::class;
            $notification->model_id = $obj->id;
            $notification->save();

            $user = $obj->user()->first();
            $params = [
                'email' => $user->email,
                'name' => $user->full_name,
                'url' => sprintf('%s/auth/profile#%s', env('APP_URL'), base64_encode(json_encode(
                    [
                        'tab' => 'notifications',
                        'model' => Testimony::class,
                        'id' => $obj->id
                    ]
                )))
            ];
            $users = User::isAdmin()->get();
            Notification::send($users, new StandardNotification($notification, 'AVISO – NUEVO TESTIMONIO', 'admin.testimony', ['database', 'brevo'], $params));
        });

        static::addGlobalScope('testimonyCategory', function ($q) {
            $q->whereHas('category', function ($q1) {
                $q1->where('name', 'testimonios');
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOwner($query)
    {
        $user = auth()->user();
        return $user->isAnAdmin() ? $query : $query->where('user_id', $user->id);
    }

    public function scopeActive($query)
    {
        return $query->where('public_access', true);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getUserNameAttribute()
    {
        return $this->user?->full_name ?? 'anonimo';
    }

    public function getVolumesAttribute()
    {
        return $this->user?->book_volumes ?? null;
    }
}
