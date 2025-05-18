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

        $app = Application::create([
            'name' => 'Plataformas',
            'ico' => 'mdi-web'
        ]);

        $modules = ['School', 'Conference', 'Learning', 'Newsletter', 'Post', 'BriefIdea'];
        foreach ($modules as $m) {
            $module = Module::firstWhere('model', $m);
            $module->application_id = $app->id;
            $module->save();
        }

        $app = Application::create([
            'name' => 'Publicaciones',
            'ico' => 'mdi-comment-text-outline'
        ]);

        $modules = ['Category', 'File', 'PushMessage', 'Campaign'];
        foreach ($modules as $m) {
            $module = Module::firstWhere('model', $m);
            $module->application_id = $app->id;
            $module->save();
        }

        $app = Application::firstWhere('name', 'Administracion');
        $module = Module::firstWhere('model', 'Testimony');
        $module->application_id = $app->id;
        $module->save();

        $app = Application::firstWhere('name', 'configuracion');
        $module = Module::firstWhere('model', 'CategoryNomenclature');
        $module->application_id = $app->id;
        $module->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $modules = ['School', 'Conference', 'Newsletter', 'Post', 'BriefIdea', 'Testimony', 'Category', 'File', 'PushMessage', 'Campaign', 'Learning', 'CategoryNomenclature'];
        foreach ($modules as $m) {
            $module = Module::firstWhere('model', $m);
            $module->application_id = null;
            $module->save();
        }

        Application::whereIn('name', ['Plataformas', 'Publicaciones'])->delete();

        $module = Module::firstWhere('model', 'Learning');
        if ($module) {
            $module->delete();
        }

        CategoryNomenclature::where('key', 'panels')->where('value', 'aprender a liberar')->first()->delete();
    }
};
