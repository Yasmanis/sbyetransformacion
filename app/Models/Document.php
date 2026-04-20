<?php

namespace App\Models;

use App\Traits\Recyclable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Document extends Model implements Sortable
{
    use SortableTrait, Recyclable;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];
    protected $fillable = ['name', 'is_folder', 'parent_id', 'user_id', 'type', 'size', 'path', 'sort_order'];

    protected $appends = ['has_childs'];

    protected $casts = [
        'is_folder' => 'boolean',
    ];

    public function buildSortQuery()
    {
        return static::query()->where('parent_id', $this->parent_id);
    }

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
