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
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->password = Hash::make($obj->password);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'surname',
        'email',
        'password',
        'sa',
        'active'
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

    protected $appends = ['permissions', 'roles', 'full_name'];

    public function getPermissionsAttribute()
    {
        return $this->permissions()->get()->pluck('id');
    }

    public function getRolesAttribute()
    {
        return $this->roles()->get()->pluck('id');
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getPermissions()
    {
        return $this->sa ? Permission::all() : Permission::whereIn('id', $this->getAllPermissions())->get();
    }

    public function getApps()
    {
        $modules = $this->getPermissions()->pluck('module_id');
        return Application::whereHas('modules', function ($query) use ($modules) {
            $query->whereIn('id',  $modules);
        })->select('id', 'name', 'ico')->get();
    }

    public function getModulesFromApp($app)
    {
        $modules_id = $this->getPermissions()->pluck('module_id');
        $modules = Module::whereIn('id', $modules_id)->where('application_id', $app->id)->select('id', 'singular_label', 'plural_label', 'model', 'ico', 'base_url', 'to_str')->get();
        foreach ($modules as $m) {
            $m->permissions = $this->getPermissionsFromModule($m);
        }
        return $modules;
    }

    public function getModulesDoesntHaveApp()
    {
        $permissions = $this->getPermissions()->pluck('id');
        $modules = Module::whereNull('application_id')->whereHas('permissions', function ($query) use ($permissions) {
            $query->whereIn('id',  $permissions);
        })->select('id', 'singular_label', 'plural_label', 'model', 'ico', 'base_url', 'to_str')->get();
        foreach ($modules as $m) {
            $m->permissions = $this->getPermissionsFromModule($m);
        }
        return $modules;
    }

    public function getPermissionsFromModule($module)
    {
        $permissions = $this->getPermissions()->pluck('id');
        return Permission::whereIn('id', $permissions)->where('module_id', $module->id)->select('name', 'label')->get();
    }

    public function menu()
    {
        $apps = $this->getApps();
        foreach ($apps as $a) {
            $a->modules = $this->getModulesFromApp($a);
        }
        return [
            'applications_with_module' => $apps,
            'modules_doesnt_have_app' => $this->getModulesDoesntHaveApp()
        ];
    }

    public function hasPerm($name)
    {
        return $this->getPermissions()->where('name', $name)->first() != null;
    }

    public function hasView($model)
    {
        $permissions = ['view_' . $model, 'edit_' . $model, 'delete_' . $model, 'add_' . $model];
        return ($this->sa || $this->getPermissions()->whereIn('name', $permissions)->first() != null) && $this->active;
    }

    public function hasCreate($model)
    {
        return ($this->sa || $this->hasPerm('add_' . $model)) && $this->active;
    }

    public function hasUpdate($model)
    {
        return ($this->sa || $this->hasPerm('edit_' . $model)) && $this->active;
    }

    public function hasDelete($model)
    {
        return ($this->sa || $this->hasPerm('delete_' . $model)) && $this->active;
    }
}
