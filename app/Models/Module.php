<?php

namespace App\Models;

use App\Traits\Recyclable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class Module extends Model
{
    use HasFactory, Recyclable;

    protected $fillable = ['singular_label', 'plural_label', 'model', 'ico', 'base_url', 'to_str', 'application_id', 'ico_from_path', 'parent_id', 'exclude_childs', 'order'];

    protected $casts = [
        'ico_from_path' => 'boolean',
        'exclude_childs' => 'boolean',
    ];

    public function app()
    {
        return $this->belongsTo(Application::class);
    }

    public function parent()
    {
        return $this->belongsTo(Module::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(Module::class, 'parent_id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function scopeSchool($query)
    {
        return $query->whereHas('parent', function ($q) {
            return $q->where('singular_label', 'Escuela');
        });
    }

    protected function getRecycleBinTitle()
    {
        return $this->plural_label;
    }

    public function setPermissions($full = false)
    {
        $permissions = [
            [
                'code' => 'add',
                'translate' => 'Adicionar'
            ],
            [
                'code' => 'edit',
                'translate' => 'Actualizar'
            ],
            [
                'code' => 'delete',
                'translate' => 'Eliminar'
            ],
            [
                'code' => 'view',
                'translate' => 'Ver'
            ]
        ];

        if ($full) {
            $permissions[] =
                [
                    'code' => 'full',
                    'translate' => 'Ver sin restricciones'
                ];
        }

        foreach ($permissions as $p) {
            $permission = new Permission();
            $permission->name = $p['code'] . '_' . Str::lower($this->model);
            $permission->label = $p['translate'];
            $permission->module_id = $this->id;
            $permission->save();
        }
    }
}
