<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PrivateMsg extends Model
{
    use HasFactory;
    protected $table = 'private_msg';

    protected $casts = [
        'read_by_to' => 'boolean',
        'delete_by_from' => 'boolean',
        'delete_by_to' => 'boolean',
        'highlight_by_to' => 'boolean'
    ];

    protected $with = ['parent', 'from', 'users', 'users.user', 'attachments'];

    protected $appends = ['to', 'read', 'highlight', 'note', 'owner'];

    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function parent()
    {
        return $this->belongsTo(PrivateMsg::class, 'parent_id');
    }

    public function users()
    {
        return $this->hasMany(PrivateMsgReceived::class, 'message_id');
    }

    public function attachments()
    {
        return $this->hasMany(PrivateMsgAttachments::class, 'message_id');
    }

    public function interactions()
    {
        return $this->hasMany(PrivateMsg::class, 'parent_id');
    }

    public function archived_by_user()
    {
        return $this->belongsToMany(User::class, "private_msg_archived", "message_id", "user_id");
    }

    public function deleted_by_user()
    {
        return $this->belongsToMany(User::class, "private_msg_deleted", "message_id", "user_id");
    }

    public function getToAttribute()
    {
        $to = $this->to()->get();
        return count($to) > 0 ? $to[0] : auth()->user();
    }

    public function getReadAttribute()
    {
        $read = false;
        if ($this->parent == null) {
            $prm = PrivateMsgReceived::where('message_id', $this->id)->where('user_id', auth()->user()->id)->first();
            if ($prm != null) {
                $read = $prm->read;
            }
        } else {
            $read = $this->read_by_to;
        }
        return $read;
    }

    public function getHighlightAttribute()
    {
        $highlight = false;
        if ($this->parent == null) {
            $prm = PrivateMsgReceived::where('message_id', $this->id)->where('user_id', auth()->user()->id)->first();
            if ($prm != null) {
                $highlight = $prm->highlight;
            }
        } else {
            $highlight = $this->highlight_by_to && $this->to->id == auth()->user()->id;
        }
        return $highlight;
    }

    public function getNoteAttribute()
    {
        $m = PrivateMsgUserNote::where('user_id', auth()->user()->id)->where('message_id', $this->id)->first();
        return $m != null && $m->note != null ? json_decode($m->note) : null;
    }

    public function getOwnerAttribute()
    {
        return $this->from->full_name;
    }

    public function setInteractions()
    {
        $logged_user = auth()->user()->id;
        $other_user = $logged_user == $this->to->id ? $this->from()->get()[0]->id : $this->to->id;
        $this->interactions = PrivateMsg::where('parent_id', $this->parent->id ?? $this->id)->where(function (Builder $query) use ($logged_user) {
            return $query->where('to_id', $logged_user)->orWhere('from_id', $logged_user);
        })->where(function (Builder $query) use ($other_user) {
            return $query->where('to_id', $other_user)->orWhere('from_id', $other_user);
        })->orderBy('id', 'asc')->get();
    }

    public function scopeByUser($query)
    {
        $id = auth()->user()->id;
        return $query->whereHas('users', function (Builder $query) use ($id) {
            $query->where('user_id', $id);
        });
    }

    public function scopeFromTo($query, $from)
    {
        return $query->where('from_id', $from);
    }

    public function scopeSendTo($query, $to)
    {
        return $query->whereHas('users', function (Builder $query) use ($to) {
            $query->where('user_id', $to);
        });
    }

    public function scopeNotArchivedByUser($query)
    {
        $id = auth()->user()->id;
        return $query->whereDoesntHave('archived_by_user', function (Builder $query) use ($id) {
            $query->where('user_id', $id);
        });
    }

    public function scopeNotDeletedByUser($query)
    {
        $id = auth()->user()->id;
        return $query->whereDoesntHave('deleted_by_user', function (Builder $query) use ($id) {
            $query->where('user_id', $id);
        });
    }

    public function scopeArchivedByUser($query)
    {
        $id = auth()->user()->id;
        return $query->whereHas('archived_by_user', function (Builder $query) use ($id) {
            $query->where('user_id', $id);
        });
    }

    public function scopeDeletedByUser($query)
    {
        $id = auth()->user()->id;
        return $query->whereHas('deleted_by_user', function (Builder $query) use ($id) {
            $query->where('user_id', $id);
        });
    }
}