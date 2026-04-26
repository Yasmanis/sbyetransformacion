<?php

namespace App\Models;

use App\Traits\Recyclable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

    protected $appends = ['has_childs', 'users'];

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
        $permissionSubquery = DB::table('documents as d_sub')
            ->selectRaw("
            CASE 
                WHEN d_sub.user_id = ? THEN 'owner'
                ELSE (
                    WITH RECURSIVE path AS (
                        SELECT id, parent_id FROM documents WHERE id = d_sub.id
                        UNION ALL
                        SELECT doc.id, doc.parent_id FROM documents doc 
                        JOIN path ON doc.id = path.parent_id
                    )
                    SELECT du.access 
                    FROM user_documents du
                    WHERE du.document_id IN (SELECT id FROM path) 
                      AND du.user_id = ?
                    ORDER BY FIELD(du.access, 'edit', 'read') ASC
                    LIMIT 1
                )
            END", [$userId, $userId])
            ->whereColumn('d_sub.id', 'documents.id');
        $query->addSelect([
            'permission' => $permissionSubquery
        ]);
        return $query->havingRaw('permission IS NOT NULL');
    }

    public function getHasChildsAttribute()
    {
        return $this->childs()->exists();
    }

    public function getUsersAttribute()
    {
        return $this->sharedWith()->get()->pluck('id');
    }
}
