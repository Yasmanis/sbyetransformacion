<?php

use App\Models\Module;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_sections', function (Blueprint $table) {
            $table->string('category')->after('description')->default('school');
        });
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
            'singular_label' => 'Conferencia',
            'plural_label' => 'Conferencias',
            'model' => 'Conference',
            'ico' => 'mdi-webcam',
            'base_url' => '/admin/conference',
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
        Schema::table('school_sections', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        $module = Module::firstWhere('model', 'Conference');
        if ($module) {
            $module->delete();
        }
    }
};
