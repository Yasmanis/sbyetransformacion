<?php

namespace App\Models;

use App\Notifications\StandardNotification;
use App\Services\BrevoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;

class SchoolChat extends Model
{
    protected $appends = ['from_name', 'reply_to_msg', 'reply_to_user', 'owner', 'owner_reply', 'owner_visible', 'delete_by_user', 'topic_str', 'section_str', 'created_str', 'section_id', 'segment'];

    protected $table = 'schoolchat';

    protected $casts = [
        'from_visible' => 'boolean'
    ];

    public function getFromNameAttribute()
    {
        return $this->from->full_name;
    }

    public function getReplyToMsgAttribute()
    {
        return $this->replyTo ? $this->replyTo->message : null;
    }

    public function getReplyToUserAttribute()
    {
        return $this->replyTo ? $this->replyTo->from->full_name : null;
    }

    public function getOwnerAttribute()
    {
        return auth()->user()->id == $this->from->id;
    }

    public function getTopicStrAttribute()
    {
        return $this->topic->name;
    }

    public function getSectionStrAttribute()
    {
        return $this->topic->section()->first()->name;
    }

    public function getSectionIdAttribute()
    {
        $topic = $this->topic->section_id;
        return $topic;
    }

    public function getSegmentAttribute()
    {
        return $this->topic->section()->first()->category;
    }

    public function getCreatedStrAttribute()
    {
        return $this->created_at->format('d/m/Y h:i A');
    }

    public function getOwnerReplyAttribute()
    {
        return $this->replyTo ? auth()->user()->id == $this->replyTo->from->id : false;
    }

    public function getOwnerVisibleAttribute()
    {
        return $this->from_visible; // || auth()->user()->isPersonalSbyeDieta();
    }

    public function getDeleteByUserAttribute()
    {
        return true;
    }

    public function deleteFromUser()
    {
        $user = auth()->user();
        $this->users()->detach($user);
        if ($this->from == $user) {
            $this->from_deleted = true;
            $this->save();
        }
        if (count($this->users) == 0 && $this->from_deleted) {
            $this->delete();
        }
    }

    public function sendNotifications($edit = false)
    {
        $notification = new UserNotifications();
        $notification->title = $edit ? 'modificación de mensaje en el chat' : 'tiene un nuevo mensaje en el chat';
        $notification->priority = 'Baja';
        $notification->user_id = auth()->user()->id;
        if ($edit) {
            $notification->description = $this->from_visible ? sprintf('el usuario %s ha modificado un mensaje en el chat', $this->from->full_name) : 'se ha modificado un mensaje en el chat';
        } else {
            $notification->description = $this->from_visible ? sprintf('el usuario %s le ha escrito en el chat', $this->from->full_name) : 'se le ha escrito en el chat de forma anonima';
        }
        $notification->code = 'chat_writter';
        $notification->model = 'SchoolChat';
        $notification->model_id = $this->id;
        $notification->save();
        $user = auth()->user();
        Notification::send(User::where('id', 1)->get(), new StandardNotification(
            $notification,
            'AVISO – contestar NUEVO MENSAJE DE CHAT',
            'admin.chat',
            ['database', 'brevo'],
            [
                'email' => $user->email,
                'name' => $user->full_name,
                'course' => $this->topic->section->getNameByCategory(),
                'url' => sprintf('%s/admin/school/#chat-%s-%s-%s', env('APP_URL'), $this->id, $this->topic_id, $this->topic->section_id)
            ]
        ));

        return true;
    }

    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
    public function replyTo()
    {
        return $this->belongsTo(SchoolChat::class, 'reply_to');
    }
    public function messages()
    {
        return $this->hasMany(SchoolChat::class);
    }
    public function topic()
    {
        return $this->belongsTo(SchoolTopic::class, 'topic_id');
    }
    public function attachments()
    {
        return $this->hasMany(SchoolChat_Attachment::class, 'chat_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'schoolchat_users', 'chat_id', 'user_id');
    }
    public function reacts()
    {
        return $this->belongsToMany(User::class, 'schoolchat_react', 'chat_id', 'user_id');
    }
    public function highligths()
    {
        return $this->belongsToMany(User::class, 'schoolchat_highligth', 'chat_id', 'user_id');
    }


    public function scopeNoFromDeleted($query)
    {
        return $query->where('from_deleted', false);
    }
    public function scopeSend($query)
    {
        return $query->where('from_id', auth()->user()->id)->where('from_deleted', false);
    }
    public function scopeReceived($query)
    {
        return $query->whereHas('users', function (Builder $query) {
            $query->where('user_id', auth()->user()->id);
        });
    }
    public function scopeFromTopic($query, $topic)
    {
        return $query->where('topic_id', $topic);
    }
}
