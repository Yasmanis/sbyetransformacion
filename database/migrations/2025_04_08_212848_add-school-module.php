<?php

use App\Models\Application;
use App\Models\Module;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->boolean('ico_from_path')->after('name')->default(false);
        });

        $app = Application::create([
            'name' => 'Escuela',
            'ico' => 'mdi-school-outline'
        ]);

        $modules = ['School', 'Learning'];
        foreach ($modules as $m) {
            $module = Module::firstWhere('model', $m);
            $module->application_id = $app->id;
            $module->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('ico_from_path');
        });

        $app = Application::firstWhere('name', 'Plataformas');

        $modules = ['School', 'Learning'];
        foreach ($modules as $m) {
            $module = Module::firstWhere('model', $m);
            $module->application_id = $app->id;
            $module->save();
        }
    }
};
