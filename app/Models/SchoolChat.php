<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SchoolChat extends Model
{
    protected $appends = ['from_name', 'reply_to_msg', 'reply_to_user', 'owner', 'owner_reply', 'owner_visible', 'delete_by_user'];

    protected $table = 'schoolchat';

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

    public function getOwnerReplyAttribute()
    {
        return $this->replyTo ? auth()->user()->id == $this->replyTo->from->id : false;
    }

    public function getOwnerVisibleAttribute()
    {
        return (bool)$this->from_visible; // || auth()->user()->isPersonalSbyeDieta();
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
