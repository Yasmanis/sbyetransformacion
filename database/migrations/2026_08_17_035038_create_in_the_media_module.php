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
        $module = Module::firstWhere('singular_label', 'Plataformas');

        CategoryNomenclature::create(
            [
                'key' => 'panels',
                'value' => 'en los medios'
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
            'singular_label' => 'en los medios',
            'plural_label' => 'en los medios',
            'model' => 'InTheMedia',
            'ico' => 'mdi-newspaper-variant-outline',
            'ico_from_path' => false,
            'base_url' => '/admin/en-los-medios',
            'to_str' => 'name',
            'parent_id' => $module->id
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
        $module = Module::firstWhere('model', 'InTheMedia');
        if ($module) {
            $module->forceDelete();
        }
        CategoryNomenclature::where('key', 'panels')->where('value', 'en los medios')->first()->delete();
    }
};
