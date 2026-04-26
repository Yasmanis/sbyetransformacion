<?php

use App\Models\Module;
use Illuminate\Database\Migrations\Migration;
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
        $permissions = [
            [
                'code' => 'view',
                'translate' => 'Ver'
            ]
        ];

        $module = Module::create([
            'singular_label' => 'Mis documentos',
            'plural_label' => 'Mis documentos',
            'model' => 'Document',
            'ico' => 'mdi-file-account-outline',
            'base_url' => '/admin/documents',
            'to_str' => 'name',
            'order' => 4
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
        $module = Module::firstWhere('model', 'Document');
        if ($module) {
            $module->delete();
        }
    }
};
