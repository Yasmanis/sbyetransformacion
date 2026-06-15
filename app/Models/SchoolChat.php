<?php

namespace App\Models;

use App\Notifications\StandardNotification;
use App\Traits\Recyclable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SchoolChat extends Model
{
    use Recyclable;

    protected $fillable = ['message'];

    protected $appends = ['from_name', 'reply_to_msg', 'reply_to_user', 'owner', 'owner_reply', 'owner_visible', 'delete_by_user', 'topic_str', 'section_str', 'section_id', 'segment', 'segment_description', 'responses'];

    protected $table = 'schoolchat';

    protected $casts = [
        'from_visible' => 'boolean',
        'created_at' => 'datetime'
    ];

    public function getFromNameAttribute()
    {
        return $this->from?->full_name ?? 'anonimo';
    }

    public function getReplyToMsgAttribute()
    {
        return $this->replyTo ? $this->replyTo?->message : null;
    }

    public function getReplyToUserAttribute()
    {
        return $this->replyTo ? $this->replyTo?->from?->full_name : 'anonimo';
    }

    public function getOwnerAttribute()
    {
        return auth()->user()->id == $this->from?->id;
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
        return $this->topic->section()->first()?->category ?? null;
    }

    public function getSegmentDescriptionAttribute()
    {
        $categ = $this->segment;
        if ($categ) {
            $mod = Module::firstWhere('model', $categ);
            return $mod?->plural_label ?? $categ;
        }
        return $categ;
    }

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d/m/Y h:i A');
    }

    public function getOwnerReplyAttribute()
    {
        return $this->replyTo ? auth()->user()->id == $this->replyTo?->from?->id : false;
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

        /*
            $users = [];
            if ($edit) {
                $users = $this->users;
                $notification->description = $this->from_visible ? sprintf('el usuario %s ha modificado un mensaje en el chat', $this->from->full_name) : 'se ha modificado un mensaje en el chat';
            } else {
                $users = $this->replyTo ? [$this->replyTo->from] : $this->users;
                if ($this->replyTo)
                    $notification->description = 'se le ha respondido en el chat';
                else
                    $notification->description = $this->from_visible ? sprintf('el usuario %s le ha escrito en el chat', $this->from->full_name) : 'se le ha escrito en el chat de forma anonima';
            }
        */

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
        return $this->hasMany(SchoolChat::class, 'reply_to')->orderBy('id', 'ASC');
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
        $userId = auth()->user()->id ?? 0;
        return $query->where('from_id', $userId)->where('from_deleted', false);
    }

    public function scopeReceived($query)
    {
        $userId = auth()->user()->id ?? 0;
        return $query->whereHas('users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function scopeWhereNotParent($query)
    {
        return $query->whereNull('reply_to');
    }

    public function scopeWhereReceivedFromReply($query)
    {
        $userId = auth()->user()->id ?? 0;
        $chatId = $this->id;
        return $query->whereHas('users', function ($q) use ($userId, $chatId) {
            $q->where('user_id', $userId)->where('chat_id', $chatId);
        });
    }

    public function scopeFromTopic($query, $topic)
    {
        return $query->where('topic_id', $topic);
    }

    public function scopeSentByUser($query, User $user)
    {
        return $query->where('from_id', $user->id);
    }

    public function scopeReceivedByUser($query, User $user)
    {
        return $query->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }

    public function scopeForUser($query, User $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->sentByUser($user)
                ->orWhere(function ($sub) use ($user) {
                    $sub->receivedByUser($user);
                });
        });
    }

    public function scopeRootMessages($query)
    {
        return $query->whereNull('reply_to');
    }

    public function scopeChildrenOf($query, User $user, $parentId)
    {
        return $query->forUser($user)
            ->where('reply_to', $parentId);
    }

    public function scopeWhereCategory($query, $val)
    {
        return $query->whereHas('topic.section', function ($query) use ($val) {
            $query->where('category', $val);
        });
    }

    public function getResponsesAttribute()
    {
        return SchoolChat::childrenOf(auth()->user(), $this->id)->count();
    }
}
