<?php

use App\Models\Application;
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
        Schema::table('modules', function (Blueprint $table) {
            $table->softDeletes();
        });

        $app = Module::firstWhere('singular_label', 'configuracion');

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
            'singular_label' => 'Curso',
            'plural_label' => 'Cursos',
            'ico' => 'mdi-school-outline',
            'base_url' => '/admin/courses',
            'model' => 'Course',
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $module = Module::firstWhere('model', 'Course');
        if ($module) {
            $module->forceDelete();
        }

        Schema::table('modules', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
