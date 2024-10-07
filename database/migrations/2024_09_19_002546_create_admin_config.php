<?php

use App\Models\Application;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            [
                'code' => 'view',
                'translate' => 'Ver'
            ],
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
            ]
        ];

        $app = Application::create([
            'name' => 'Administracion',
            'ico' => 'mdi-cogs'
        ]);

        $module = Module::create([
            'singular_label' => 'Rol',
            'plural_label' => 'Roles',
            'model' => 'Role',
            'ico' => 'mdi-account-group-outline',
            'base_url' => '/admin/rols',
            'to_str' => 'name',
            'application_id' => $app->id
        ]);

        foreach ($permissions as $p) {
            $permission = new Permission();
            $permission->name = $p['code'] . '_' . Str::lower($module->model);
            $permission->label = $p['translate'];
            $permission->module_id = $module->id;
            $permission->save();
        }

        $module = Module::create([
            'singular_label' => 'Usuario',
            'plural_label' => 'Usuarios',
            'model' => 'User',
            'ico' => 'mdi-account-outline',
            'base_url' => '/admin/users',
            'to_str' => 'username',
            'application_id' => $app->id
        ]);

        foreach ($permissions as $p) {
            $permission = new Permission();
            $permission->name = $p['code'] . '_' . Str::lower($module->model);
            $permission->label = $p['translate'];
            $permission->module_id = $module->id;
            $permission->save();
        }

        User::create([
            'username' => 'sa',
            'email' => 'sa@sa.com',
            'name' => 'sa',
            'sa' => true,
            'password' => 'password',
        ]);

        $user = User::create([
            'username' => 'test',
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        $user->givePermissionTo(Permission::findById(1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
};
