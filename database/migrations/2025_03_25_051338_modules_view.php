<?php

use App\Models\Application;
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
    }
};