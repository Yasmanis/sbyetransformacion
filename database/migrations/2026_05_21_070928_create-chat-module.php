<?php

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
        $app = Module::firstWhere('singular_label', 'Administracion');

        $permissions = [
            [
                'code' => 'view',
                'translate' => 'Ver'
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
            'singular_label' => 'Chat',
            'plural_label' => 'Chat',
            'ico' => 'mdi-chat-processing-outline',
            'base_url' => '/admin/chats',
            'model' => 'SchoolChat',
            'to_str' => 'message',
            'parent_id' => $app->id
        ]);

        foreach ($permissions as $p) {
            $permission = new Permission();
            $permission->name = $p['code'] . '_' . Str::lower($module->model);
            $permission->label = $p['translate'];
            $permission->module_id = $module->id;
            $permission->save();
        }

        Schema::table('schoolchat', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $module = Module::firstWhere('model', 'SchoolChat');
        if ($module) {
            $module->forceDelete();
        }

        Schema::table('schoolchat', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
