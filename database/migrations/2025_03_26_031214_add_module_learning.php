<?php

use App\Models\CategoryNomenclature;
use App\Models\Module;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        $module = Module::firstWhere('singular_label', 'Vivir en plenitud');
        $module->model = 'School';
        $module->base_url = '/admin/school';
        $module->save();

        $permissions = $module->permissions()->get();
        foreach ($permissions as $p) {
            $p->name = str_replace('schoolsection', 'school', $p->name);
            $p->save();
        }

        CategoryNomenclature::create(
            [
                'key' => 'panels',
                'value' => 'aprender a liberar'
            ]
        );

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
            'singular_label' => 'Aprender a liberar',
            'plural_label' => 'Aprender a liberar',
            'model' => 'Learning',
            'ico' => 'mdi-account-school-outline',
            'base_url' => '/admin/learning',
            'to_str' => 'name',
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
        $module = Module::firstWhere('model', 'Learning');
        if ($module) {
            $module->delete();
        }

        CategoryNomenclature::where('key', 'panels')->where('value', 'aprender a liberar')->first()->delete();
    }
};