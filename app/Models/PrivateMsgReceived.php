<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateMsgReceived extends Model
{
    use HasFactory;

    protected $table = 'private_msg_received';

    public $timestamps = false;

    protected $casts = [
        'highlight' => 'boolean',
        'read' => 'boolean',
        'deleted' => 'boolean',
        'interaction' => 'boolean',
        'delete_by_user' => 'boolean',
        'delete_by_from' => 'boolean'
    ];

    public function message()
    {
        return $this->belongsTo(PrivateMsg::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(PrivateMsgReceived::class);
    }

    public function interactions()
    {
        return $this->hasMany(PrivateMsgReceived::class, 'parent_id');
    }

    public function setReadInteractions()
    {
        $reads = PrivateMsgReceived::where('user_id', auth()->user()->id)->get();
        foreach ($reads as $r) {
            if ($r->id == $this->id || ($r->parent_id != null && $r->parent_id == $this->parent_id) || $r->parent_id == $this->id) {
                $r->read = true;
                $r->save();
            }
        }
    }
}
