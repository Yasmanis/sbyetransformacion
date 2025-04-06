<?php

use App\Models\Application;
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
        Schema::create('reason_for_return', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $app = Application::firstWhere('name', 'configuracion');

        $module = Module::create([
            'singular_label' => 'Motivo de devolucion',
            'plural_label' => 'Motivos de devolucion',
            'model' => 'ReasonForReturn',
            'ico' => 'mdi-arrow-u-left-top',
            'base_url' => '/admin/reason-for-return',
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reason_for_return');
        Module::firstWhere('model', 'ReasonForReturn')->delete();
    }
};