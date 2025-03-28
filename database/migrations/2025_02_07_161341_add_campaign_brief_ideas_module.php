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
        Schema::create('brief_ideas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('message');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate();
            $table->longText('data')->nullable();
            $table->timestamps();
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->boolean('ico_from_path')->default(false)->after('ico');
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
            'singular_label' => 'Campaña',
            'plural_label' => 'Campañas',
            'model' => 'Campaign',
            'ico' => 'images/icon/white-campaign.png',
            'ico_from_path' => true,
            'base_url' => '/admin/campaigns',
            'to_str' => 'title',
        ]);

        foreach ($permissions as $p) {
            $permission = new Permission();
            $permission->name = $p['code'] . '_' . Str::lower($module->model);
            $permission->label = $p['translate'];
            $permission->module_id = $module->id;
            $permission->save();
        }

        $module = Module::create([
            'singular_label' => 'Idea breve',
            'plural_label' => 'Ideas breves',
            'model' => 'BriefIdea',
            'ico' => 'mdi-help',
            'base_url' => '/admin/briefideas',
            'to_str' => 'title',
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
        Schema::dropIfExists('brief_ideas');

        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('ico_from_path');
        });

        $module = Module::firstWhere('model', 'Campaign');
        if ($module != null)
            $module->delete();

        $module = Module::firstWhere('model', 'BriefIdea');
        if ($module != null)
            $module->delete();
    }
};
