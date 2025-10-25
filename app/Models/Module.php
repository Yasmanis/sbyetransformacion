<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Module extends Model
{
    use HasFactory;

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
}
