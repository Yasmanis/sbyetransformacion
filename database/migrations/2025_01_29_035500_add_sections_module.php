<?php

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

        $module = Module::create([
            'singular_label' => 'Seccion',
            'plural_label' => 'Secciones',
            'model' => 'CategoryNomenclature',
            'ico' => 'mdi-view-list',
            'base_url' => '/admin/sections',
            'to_str' => 'value',
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
        //
    }
};