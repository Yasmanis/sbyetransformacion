<?php

namespace App\Models;

use App\Traits\Recyclable;
use App\Traits\RowConfiguration;
use App\Traits\RowNote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Document extends Model implements Sortable
{
    use SortableTrait, Recyclable, RowConfiguration, RowNote;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];
    protected $fillable = [
        'name',
        'is_folder',
        'parent_id',
        'user_id',
        'type',
        'size',
        'path',
        'sort_order',
        'description',
        'observation'
    ];

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
        $permissionSubquery = DB::table('user_documents as du')
            ->select('du.access')
            ->join(DB::raw("(
            WITH RECURSIVE path_perm AS (
                SELECT id, parent_id, id as original_id FROM documents
                UNION ALL
                SELECT doc.id, doc.parent_id, path_perm.original_id FROM documents doc
                JOIN path_perm ON doc.id = path_perm.parent_id
            )
            SELECT id, original_id FROM path_perm
        ) as tree_p"), 'du.document_id', '=', 'tree_p.id')
            ->whereColumn('tree_p.original_id', 'documents.id')
            ->where('du.user_id', $userId)
            ->orderByRaw("FIELD(du.access, 'edit', 'read') ASC")
            ->limit(1);
        $query->addSelect([
            'permission' => function ($q) use ($userId, $permissionSubquery) {
                $q->selectRaw("
                CASE 
                    WHEN documents.user_id = ? THEN 'owner'
                    ELSE ({$permissionSubquery->toSql()})
                END", [$userId, ...$permissionSubquery->getBindings()]);
            }
        ]);

        return $query->whereNull('documents.deleted_at')
            ->whereNotIn('documents.id', function ($q) {
                $q->select('id')
                    ->from(DB::raw("(
                  WITH RECURSIVE deshuesado AS (
                      SELECT id, parent_id 
                      FROM documents 
                      WHERE deleted_at IS NOT NULL
                      UNION ALL
                      SELECT doc.id, doc.parent_id 
                      FROM documents doc
                      JOIN deshuesado d ON doc.parent_id = d.id
                  )
                  SELECT id FROM deshuesado
              ) as lista_negra"));
            })
            ->havingRaw('permission IS NOT NULL');
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
