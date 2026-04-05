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
    protected $tables = ['users', 'push_messages', 'file', 'messages'];

    public function up()
    {
        foreach ($this->tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        Schema::create('recycle_bin', function (Blueprint $table) {
            $table->id();
            $table->string('recyclable_type');
            $table->unsignedBigInteger('recyclable_id');
            $table->string('title')->nullable();
            $table->unsignedBigInteger('deleted_by');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('auto_delete_at')->nullable();
            $table->timestamps();

            $table->index(['recyclable_type', 'recyclable_id']);
        });

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

        $app = Module::firstWhere('singular_label', 'administracion');

        $module = Module::create([
            'singular_label' => 'Papelera',
            'plural_label' => 'Papelera',
            'model' => 'RecycleBin',
            'ico' => 'mdi-delete-variant',
            'base_url' => '/admin/recycle-bin',
            'to_str' => 'title',
            'parent_id' => $app->id,
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
        foreach ($this->tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        Schema::dropIfExists('recycle_bin');

        $module = Module::firstWhere('model', 'ProductSubcategory');
        if ($module) {
            $module->delete();
        }
    }
};
