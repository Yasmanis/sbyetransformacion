<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    protected $fillable = ['name', 'is_folder', 'parent_id', 'user_id', 'type', 'size', 'path'];

    protected $appends = ['has_childs'];

    protected $casts = [
        'is_folder' => 'boolean',
    ];

    public function sharedWith()
    {
        return $this->belongsToMany(User::class, 'user_documents');
    }

    public function childs()
    {
        return $this->hasMany(Document::class, 'parent_id', 'id');
    }

    public function scopeAccessibleBy($query, $userId)
    {
        return $query->where('user_id', $userId)
            ->orWhereHas('sharedWith', fn($q) => $q->where('user_id', $userId));
    }

    public function getHasChildsAttribute()
    {
        return $this->childs()->exists();
    }
}
