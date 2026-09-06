<?php

namespace App\Models;

use App\Notifications\StandardNotification;
use App\Traits\Recyclable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class SchoolChat extends Model
{
    use Recyclable;

    protected $fillable = ['message'];

    protected $appends = ['from_name', 'reply_to_msg', 'reply_to_user', 'owner', 'owner_reply', 'owner_visible', 'delete_by_user', 'topic_str', 'section_str', 'section_id', 'segment', 'responses', 'module_str', 'submodule_str'];

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
        return $this->topicable->name;
    }

    public function getSectionStrAttribute()
    {
        $catName = null;
        if ($this->topicable instanceof File) {
            $catName = $this->topicable->category_str;
        } else {
            $catName = $this->topicable->section()->first()->name;
        }
        return $catName;
    }

    public function getSectionIdAttribute()
    {
        return $this->topicable->section_id;
    }

    public function getSegmentAttribute()
    {
        $s = $this->topicable->section()->first();
        return $s ? Str::lower($s->module->model) : null;
    }

    public function getModuleStrAttribute()
    {
        $categ = $this->segment;
        if ($categ) {
            $mod = Module::firstWhere('model', $categ);
            if ($mod?->parent) {
                return $mod->parent->plural_label ?? $categ;
            }
        }
        return $categ;
    }

    public function getSubmoduleStrAttribute()
    {
        $categ = $this->segment;
        if ($categ) {
            $mod = Module::firstWhere('model', $categ);
            return $mod->plural_label ?? $categ;
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

        $notification->code = 'chat_writter';
        $notification->model = 'SchoolChat';
        $notification->model_id = $this->id;
        $notification->save();
        $user = auth()->user();
        $catName = null;
        if ($this->topicable instanceof File) {
            $catName = $this->topicable->category_str;
        } else {
            $catName = $this->topicable->section->getNameByCategory();
        }
        Notification::send($users, new StandardNotification(
            $notification,
            'AVISO – contestar NUEVO MENSAJE DE CHAT',
            'admin.chat',
            ['database', 'brevo'],
            [
                'email' => $user->email,
                'name' => $user->full_name,
                'course' => $catName,
                'url' => sprintf('%s/admin/school/#chat-%s-%s-%s', env('APP_URL'), $this->id, $this->topicable->id, $this->topicable->section_id)
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
    public function topicable()
    {
        return $this->morphTo();
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

    public function scopeWhereTopic($query, $topicable)
    {
        [$id, $type] = explode(':', $topicable[0], 2);
        return $query->where('topicable_id', $id)->where('topicable_type', $type);
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

    public function scopeWhereModule($query, $val)
    {
        $models = Module::where('parent_id', $val)->get()->pluck('id');
        if (!empty($models)) {
            return $query->whereHasMorph('topicable', [SchoolTopic::class, File::class], function ($query) use ($models) {
                $query->whereHas('section', function ($q) use ($models) {
                    $q->whereIn('module_id', $models);
                });
            });
        }
        return $query;
    }

    public function scopeWhereSubmodule($query, $val)
    {
        $m = Module::find($val[0]);
        if ($m) {
            return $query->whereHasMorph('topicable', [SchoolTopic::class, File::class], function ($query) use ($m) {
                $query->whereHas('section', function ($q) use ($m) {
                    $q->where('module_id', $m->id);
                });
            });
        }
        return $query;
    }

    public function scopeWhereSection($query, $val)
    {
        return $query->whereHasMorph('topicable', [SchoolTopic::class, File::class], function ($query) use ($val) {
            $query->whereHas('section', function ($q) use ($val) {
                $q->where('id', $val);
            });
        });
    }

    public function getResponsesAttribute()
    {
        return SchoolChat::childrenOf(auth()->user(), $this->id)->count();
    }

    public function scopeWhereHighligth($query, $val)
    {
        return $query->withCount('highligths')->havingBetween('highligths_count', [$val->min, $val->max]);
    }

    public function scopeWhereReact($query, $val)
    {
        return $query->withCount('reacts')->havingBetween('reacts_count', [$val->min, $val->max]);
    }

    public function scopeWhereResponses($query, $val)
    {
        if ($val) {
            return $query->whereNotNull('reply_to')->whereHas('from', function ($q) {
                $q->personalSbyeTransformacion();
            });
        }
        return $query;
    }
}
