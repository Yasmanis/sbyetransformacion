<?php

use App\Models\Module;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $module = Module::create(
            [
                'singular_label' => 'Plataformas',
                'plural_label' => 'Plataformas',
                'ico' => 'mdi-web',
            ]
        );
        $models = ['Post', 'Newsletter', 'Conference', 'BriefIdea'];
        $modules = Module::whereIn('model', $models)->get();
        foreach ($modules as $m) {
            $m->parent_id = $module->id;
            $m->save();
        }

        $module = Module::create(
            [
                'singular_label' => 'Publicaciones',
                'plural_label' => 'Publicaciones',
                'ico' => 'mdi-comment-text-outline',
            ]
        );
        $models = ['Category', 'File', 'PushMessage', 'Campaign'];
        $modules = Module::whereIn('model', $models)->get();
        foreach ($modules as $m) {
            $m->parent_id = $module->id;
            $m->save();
        }

        $module = Module::create(
            [
                'singular_label' => 'Escuela',
                'plural_label' => 'Escuela',
                'ico' => 'mdi-school-outline',
            ]
        );
        $models = ['School', 'Learning', 'Reality'];
        $modules = Module::whereIn('model', $models)->get();
        foreach ($modules as $m) {
            $m->parent_id = $module->id;
            $m->save();
        }

        $module = Module::create(
            [
                'singular_label' => 'Administracion',
                'plural_label' => 'Administracion',
                'ico' => 'mdi-cogs',
                'order' => 100
            ]
        );
        $models = ['Role', 'User', 'Testimony'];
        $modules = Module::whereIn('model', $models)->get();
        foreach ($modules as $m) {
            $m->parent_id = $module->id;
            $m->save();
        }

        $module = Module::create(
            [
                'singular_label' => 'configuracion',
                'plural_label' => 'configuracion',
                'ico' => 'mdi-cog-outline',
                'order' => 101
            ]
        );

        $legal = Module::firstWhere('base_url', '/admin/configuration/legal');
        $legal->singular_label = 'textos legales';
        $legal->plural_label = 'textos legales';
        $legal->model = 'Legal';
        $legal->save();

        $news = [
            [
                'singular_label' => 'tienda',
                'plural_label' => 'tienda',
                'ico' => 'mdi-cart-outline',
                'parent_id' => $module->id,
                'exclude_childs' => true,
                'base_url' => '/admin/configuration/shopping',
                'models' => ['ReasonForReturn', 'Product', 'ProductCategory', 'Country']
            ]
        ];
        foreach ($news as $n) {
            $m = Module::create($n);
            $modules = Module::whereIn('model', $n['models'])->get();
            foreach ($modules as $mod) {
                $mod->parent_id = $m->id;
                $mod->save();
            }
        }
        $models = ['CategoryNomenclature', 'Landing', 'Legal'];
        $modules = Module::whereIn('model', $models)->get();
        foreach ($modules as $m) {
            $m->parent_id = $module->id;
            $m->save();
        }

        Module::where('model', 'Configuration')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Module::whereNull('model')->delete();

        $legal = Module::firstWhere('base_url', '/admin/configuration/legal');
        $legal->singular_label = 'aviso legal';
        $legal->plural_label = 'aviso legal';
        $legal->model = 'Configuracion';
        $legal->save();
    }
};
