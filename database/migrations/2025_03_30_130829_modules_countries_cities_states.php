<?php

use App\Models\Application;
use App\Models\Module;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $app = Application::firstWhere('name', 'configuracion');

        $module = Module::create([
            'singular_label' => 'Pais',
            'plural_label' => 'Paises',
            'model' => 'Country',
            'ico' => 'mdi-map-marker-multiple-outline',
            'base_url' => '/admin/countries',
            'to_str' => 'name',
            'application_id' => $app->id
        ]);

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

        foreach ($permissions as $p) {
            $permission = new Permission();
            $permission->name = $p['code'] . '_' . Str::lower($module->model);
            $permission->label = $p['translate'];
            $permission->module_id = $module->id;
            $permission->save();
        }

        $module = Module::create([
            'singular_label' => 'Estado',
            'plural_label' => 'Estados',
            'model' => 'State',
            'ico' => 'mdi-map-marker-outline',
            'base_url' => '/admin/states',
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
            'singular_label' => 'Ciudad',
            'plural_label' => 'Ciudades',
            'model' => 'City',
            'ico' => 'mdi-home-city-outline',
            'base_url' => '/admin/cities',
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Module::whereIn('model', ['Country', 'City', 'State'])->delete();
    }
};