<?php

use App\Models\Application;
use App\Models\CategoryNomenclature;
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
        $app = Application::firstWhere('name', 'Escuela');

        CategoryNomenclature::create(
            [
                'key' => 'panels',
                'value' => 'crear la realidad'
            ]
        );

        $permissions = [
            [
                'code' => 'view',
                'translate' => 'Ver'
            ],
            [
                'code' => 'full',
                'translate' => 'Ver sin restricciones'
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

        $module = Module::create([
            'singular_label' => 'Crear la realidad',
            'plural_label' => 'Crear la realidad',
            'model' => 'Reality',
            'ico' => 'images/icon/white-star.png',
            'ico_from_path' => true,
            'base_url' => '/admin/reality',
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
        $module = Module::firstWhere('model', 'Reality');
        if ($module) {
            $module->delete();
        }
        CategoryNomenclature::where('key', 'panels')->where('value', 'crear la realidad')->first()->delete();
    }
};
