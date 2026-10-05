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
        $parent = Module::firstWhere('code', 'configuracion_code');

        $m = Module::create([
            'singular_label' => 'publicaciones',
            'plural_label' => 'publicaciones',
            'code' => 'publications_config',
            'ico' => 'mdi-web',
            'parent_id' => $parent->id,
            'exclude_childs' => true,
            'base_url' => '/admin/configuration/publications',
            'models' => ['Category', 'PublicationSubcategory', 'File']
        ]);

        $module = Module::create([
            'singular_label' => 'Subcategoria',
            'plural_label' => 'Subcategorias',
            'code' => 'subcategory_publications',
            'model' => 'PublicationSubcategory',
            'ico' => 'mdi-sitemap-outline',
            'base_url' => '/admin/publication-subcategories',
            'to_str' => 'name',
            'parent_id' => $m->id,
            'order' => 2
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

        $module = Module::firstWhere('code', 'category_code');
        $module->order = 1;
        $module->parent_id = $m->id;
        $module->save();

        $module = Module::firstWhere('code', 'subcategory_publications');
        $module->order = 2;
        $module->save();

        $module = Module::firstWhere('code', 'file_code');
        $module->order = 3;
        $module->parent_id = $m->id;
        $module->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $codes = ['subcategory_publications', 'publications_config'];
        foreach ($codes as $c) {
            $m = Module::firstWhere('code', $c);
            if ($m) {
                $m->forceDelete();
            }
        }

        $m = Module::firstWhere('code', 'publicar_code');

        $module = Module::firstWhere('code', 'category_code');
        $module->parent_id = $m->id;
        $module->save();

        $module = Module::firstWhere('code', 'file_code');
        $module->order = 2;
        $module->parent_id = $m->id;
        $module->save();
    }
};
