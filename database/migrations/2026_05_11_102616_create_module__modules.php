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

        $app = Module::firstWhere('singular_label', 'configuracion');

        $permissions = [
            [
                'code' => 'view',
                'translate' => 'Ver'
            ],
            [
                'code' => 'edit',
                'translate' => 'Actualizar'
            ]
        ];

        $module = Module::create([
            'singular_label' => 'Modulo',
            'plural_label' => 'Modulos',
            'ico' => 'mdi-cogs',
            'base_url' => '/admin/modules',
            'model' => 'Module',
            'to_str' => 'name',
            'parent_id' => $app->id
        ]);

        foreach ($permissions as $p) {
            $permission = new Permission();
            $permission->name = $p['code'] . '_' . Str::lower($module->model);
            $permission->label = $p['translate'];
            $permission->module_id = $module->id;
            $permission->save();
        }

        Module::all()->each(function ($module, $index) {
            $module->order = $index + 1;
            $module->save();
        });

        $mod = Module::firstWhere(
            'plural_label',
            'Reflexiona'
        );
        if ($mod) {
            $mod->update([
                'plural_label' => 'Reflexiona!'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $module = Module::firstWhere('model', 'Module');
        if ($module) {
            $module->forceDelete();
        }
    }
};
