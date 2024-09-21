<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'sa'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'sa' => 'boolean',
        'active' => 'boolean'
    ];

    public function permsByModel($model)
    {
        if ($this->sa) {
            return $model->permissions()->select('id', 'name', 'label')->get();
        }
        return $this->getAllPermissions()->filter(function ($p) use ($model) {
            return $p->module_id = $model->id;
        });
    }

    public function getApps()
    {
        $modules = $this->sa ? Permission::select('module_id')->get() : $this->getAllPermissions()->pluck('module_id');
        return Application::whereHas('modules', function($query) use ($modules) {
            $query->whereIn('id',  $modules);
        })->select('id', 'name', 'ico')->get();
    }

    public function getModulesFromApp($app)
    {
        $modules = $this->sa ? Permission::select('module_id')->get() : $this->getAllPermissions()->pluck('module_id');
        return Module::whereIn('id', $modules)->where('application_id', $app->id)->select('id', 'name', 'model', 'ico', 'url')->get();
    }

    public function getPermissionsFromModule($module)
    {
        $permissions = $this->sa ? Permission::select('id')->get() : $this->getAllPermissions()->pluck('module_id');
        return Permission::whereIn('id', $permissions)->where('module_id', $module->id)->select('name', 'label')->get();
    }

    public function appList()
    {
        $apps = $this->getApps();
        foreach ($apps as $a) {
            $modules = $this->getModulesFromApp($a);
            foreach ($modules as $m) {
                $m->permissions = $this->getPermissionsFromModule($m);
            }
            $a->modules = $modules;
        }
        return $apps;
    }

    public function hasAccess($perm)
    {
        $p = Permission::firstWhere('name', '=', strtolower($perm));
        return isset($p) ? ($this->sa ? true : $this->hasPermissionTo($p)) : false;
    }
}
