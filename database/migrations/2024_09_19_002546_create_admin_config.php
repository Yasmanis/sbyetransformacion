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
            'name' => 'Roles',
            'model' => 'Role',
            'ico' => 'mdi-account-group-outline',
            'url' => '/admin/rols',
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
            'name' => 'Usuarios',
            'model' => 'User',
            'ico' => 'mdi-account-outline',
            'url' => '/admin/users',
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
            'name' => 'sa',
            'email' => 'sa@sa.com',
            'sa' => true,
            'active' => true,
            'password' => Hash::make('password'),
        ]);

        $user = User::create([
            'name' => 'test',
            'email' => 'test@test.com',
            'sa' => false,
            'active' => true,
            'password' => Hash::make('password'),
        ]);

        $user->givePermissionTo(Permission::findById(1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};