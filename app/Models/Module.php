<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Module extends Model
{
    use HasFactory;
    protected $fillable = ['singular_label', 'plural_label', 'model', 'ico', 'base_url', 'to_str', 'application_id'];

    public function app()
    {
        return $this->belongsTo(Application::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
