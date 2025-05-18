<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
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
        'active',
        'avatar'
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
        'active' => 'boolean',
        'configuration' => 'json',
        'book_volumes' => 'json',
        'subscripted' => 'boolean',
    ];

    protected $appends = ['permissions', 'roles', 'full_name', 'notifications', 'has_testimony'];

    protected $with = ['latestCourses'];

    public function books()
    {
        return $this->hasMany(Contact::class);
    }

    public function latestCourses()
    {
        return $this->hasMany(UserLastCourse::class, 'user_id');
    }

    public function getHasTestimonyAttribute()
    {
        return Testimony::active()->where('user_id', $this->id)->count() > 0;
    }

    public function getPermissionsAttribute()
    {
        return $this->permissions()->get()->pluck('id');
    }

    public function getNotificationsAttribute()
    {
        $notifications = $this->notifications()->get();
        foreach ($notifications as $n) {
            $n['time'] = Carbon::parse($n['created_at'])->diffForHumans();
            $user = User::find($n->notifiable_id);
            $n['user'] = $user != null ? $user->full_name : '';
        }
        return $notifications;
    }

    public function getRolesAttribute()
    {
        return $this->roles()->get()->pluck('id');
    }

    public function getFullNameAttribute()
    {
        return isset($this->name) || isset($this->surname) ? ($this->name . ' ' . $this->surname) : $this->username;
    }

    public function scopeFilterByRegex($query, $regex)
    {
        return $query
            ->where('name', 'like', '%' . $regex . '%')
            ->orWhere('surname', 'like', '%' . $regex . '%');
    }

    public function scopeFilterByRole($query, $value)
    {
        return $query->whereHas('roles', function ($query) use ($value) {
            $query->where('id', $value);
        });
    }

    public function scopeIsAdmin($query)
    {
        return $query->where('sa', true)->where('active', true);
    }

    public function personalSbyeTransformacion($query)
    {
        return $query->where('sa', true)->where('active', true);
    }

    public function getRolesSbyeTranformacion()
    {
        return ['dietista'];
    }

    public function isPersonalSbyeDieta()
    {
        return $this->hasAnyRole($this->getRolesSbyeTranformacion());
    }

    public function getAllPermissions()
    {
        if ($this->sa) return  Permission::all();
        $user_id = $this->id;
        $direct_permissions = Permission::whereIn('id', $this->permissions)->select('id', 'name', 'label', 'module_id');
        $via_roles_permissions = DB::table('permissions')->join('role_has_permissions', function ($join) {
            $join->on('permissions.id', '=', 'role_has_permissions.permission_id');
        })->join('user_has_roles', function ($join) use ($user_id) {
            $join->on('role_has_permissions.role_id', '=', 'user_has_roles.role_id')->where('user_has_roles.user_id', $user_id);
        })->select('permissions.id', 'permissions.name', 'permissions.label', 'permissions.module_id');
        return $direct_permissions->union($via_roles_permissions)->distinct()->get();
    }

    public function getApps()
    {
        $modules = $this->getAllPermissions()->pluck('module_id');
        return Application::whereHas('modules', function ($query) use ($modules) {
            $query->whereIn('id',  $modules);
        })->select('id', 'name', 'ico')->get();
    }

    public function getModulesFromApp($app)
    {
        $modules_id = $this->getAllPermissions()->pluck('module_id');
        $modules = Module::whereIn('id', $modules_id)->where('application_id', $app->id)->select('id', 'singular_label', 'plural_label', 'model', 'ico', 'ico_from_path', 'ico_from_path', 'base_url', 'to_str')->get();
        foreach ($modules as $m) {
            $m->permissions = $this->getPermissionsFromModule($m);
        }
        return $modules;
    }

    public function getModulesDoesntHaveApp()
    {
        $permissions = $this->getAllPermissions()->pluck('id');
        $modules = Module::whereNull('application_id')->whereHas('permissions', function ($query) use ($permissions) {
            $query->whereIn('id',  $permissions);
        })->select('id', 'singular_label', 'plural_label', 'model', 'ico', 'ico_from_path', 'base_url', 'to_str')->get();
        foreach ($modules as $m) {
            $m->permissions = $this->getPermissionsFromModule($m);
        }
        return $modules;
    }

    public function getPermissionsFromModule($module)
    {
        $permissions = $this->getAllPermissions()->pluck('id');
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
        return $this->getAllPermissions()->where('name', $name)->first() != null;
    }

    public function hasView($model)
    {
        $permissions = ['view_' . $model, 'edit_' . $model, 'delete_' . $model, 'add_' . $model];
        return ($this->sa || $this->getAllPermissions()->whereIn('name', $permissions)->first() != null) && $this->active;
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

    public function getCoursePercentage($segment)
    {
        $sections = SchoolSection::type($segment)->get();
        $time_view = 0;
        $time_access = 0;
        $total_time = 0;
        foreach ($sections as $s) {
            $time_view += $s->getTotalTimeViewByUser($this);
            $time_access += $s->getTotalTimeAccessByUser($this);
            $total_time += $s->getTotalTime();
        }

        if ($total_time == 0) return 100;
        if ($time_access == 0 && $total_time > 0) return 0;
        return ($time_view / $total_time) * 100;
    }

    public function getSections($type)
    {
        return SchoolSection::type($type)->get();
    }

    public function getTopicsBySection($type)
    {
        $all_sections = SchoolSection::type($type)->get();
        $topics = [];
        $sections = [];
        $volumes = $this->book_volumes ? $this->book_volumes : [];
        foreach ($all_sections as $s) {
            foreach ($s->topics as $t) {
                if (!$this->sa && $type != 'conference') {
                    if (in_array($t->book_volume, $volumes)) {
                        $topics[] = [
                            'id' => $t->id,
                            'name' => $t->name,
                            'percent' => $t->getPercentByUser($this)
                        ];
                    }
                } else {
                    $topics[] = [
                        'id' => $t->id,
                        'name' => $t->name,
                        'percent' => $t->getPercentByUser($this)
                    ];
                }
            }
            if (count($topics) > 0) {
                $ss = $s;
                $ss['topics'] = $topics;
                $sections[] = [
                    'id' => $s->id,
                    'name' => $s->name,
                    'percent' => $s->getPercentByUser($this),
                    'topics' => $topics
                ];
                $topics = [];
            }
        }
        return [
            'percent' => $this->getCoursePercentage($type),
            'sections' => $sections
        ];
    }

    public function getComments()
    {
        $id = $this->id;
        $messages = SchoolChat::where('from_id', $this->id)->get();
        $reacts = SchoolChat::whereHas('reacts', function (Builder $query) use ($id) {
            $query->where('user_id', $id);
        })->get();
        $highligths = SchoolChat::whereHas('highligths', function (Builder $query) use ($id) {
            $query->where('user_id', $id);
        })->get();
        return [
            'comments' => $messages,
            'reacts' => $reacts,
            'highligths' => $highligths
        ];
    }

    public function applyFiltersMessage($query, $request, $exclude_search = false)
    {
        if (!$exclude_search) {
            if (isset($request->query_str)) {
                $query = $query->where('title', 'like', '%' . $request->query_str . '%');
            }
            if (isset($request->filters)) {
                foreach ($request->filters as $f) {
                    if (isset($f['scope'])) {
                        $query = $query->{$f['scope']}($f['value']);
                    } else {
                        $query = $query->dinamicFilter($f);
                    }
                }
            }
        }
        return $query;
    }

    public function getPrivateMessages($request, $type)
    {
        $messages = [];
        $id = $this->id;
        if ($type === 'send') {
            $messages = PrivateMsg::where('from_id', $id)->whereHas('users')->notArchivedByUser()->notDeletedByUser();
            $messages = $this->applyFiltersMessage($messages, $request)->get();
        } else if ($type === 'received') {
            $messages = $this->applyFiltersMessage(PrivateMsg::byUser(), $request)->get();
            $first_interactions = $this->applyFiltersMessage(PrivateMsg::where('to_id', $id)->select('from_id', 'parent_id'), $request)->distinct()->get();
            foreach ($first_interactions as $i) {
                if ($messages->where('id', $i->parent_id)->first() == null) {
                    $messages[] = $this->applyFiltersMessage(PrivateMsg::where('from_id', $i->from_id)->where('parent_id', $i->parent_id), $request)->orderBy('id', 'desc')->first();
                }
            }
            $index = 0;
            foreach ($messages as $m) {
                $interaction = $this->applyFiltersMessage(PrivateMsg::where('parent_id', $m->id)->where('to_id', $id), $request)->orderBy('id', 'desc')->first();
                if ($interaction != null) {
                    $messages[$index] = $interaction;
                }
                $index++;
            }
            $archived = PrivateMsg::archivedByUser()->select('id');
            $deleted = PrivateMsg::deletedByUser()->select('id');
            $filtered = $archived->union($deleted)->distinct()->get()->pluck('id');
            $messages = $messages->whereNotIn('id', $filtered);
        } else {
            $messages = $this->applyFiltersMessage(PrivateMsg::archivedByUser()->notDeletedByUser(), $request)->get();
        }
        $messages = collect($messages);
        if (isset($request->sortBy)) {
            $messages = $messages->sortBy([[$request->sortBy, (bool)$request->descending ? 'desc' : 'asc']]);
        } else {
            $messages = $messages->sortBy([
                [
                    'highlight',
                    'desc'
                ],
                [
                    'read',
                    'asc'
                ],
                ['id', 'desc']
            ]);
        }
        if (isset($request->rowsPerPage)) {
            $messages = $messages->forPage($request->page, $request->rowsPerPage);
        }
        foreach ($messages as $m) {
            $m->setInteractions();
        }
        return $messages->values()->all();
    }
}
