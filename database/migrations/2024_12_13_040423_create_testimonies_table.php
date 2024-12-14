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
        Schema::create('testimonies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('message')->nullable();
            $table->enum('type', ['text', 'video']);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('publicated')->default(false);
            $table->timestamps();
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
            'singular_label' => 'Testimonio',
            'plural_label' => 'Testimonios',
            'model' => 'Testimony',
            'ico' => 'mdi-video-account',
            'base_url' => '/admin/testimony',
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
        Schema::dropIfExists('testimonies');
        $module = Module::where('model', 'Testimony')->first();
        if (isset($module)) {
            $module->delete();
        }

        $permissions = [
            'view',
            'add',
            'edit',
            'delete'
        ];

        foreach ($permissions as $code) {
            $p = Permission::where('name', $code . '_testimony')->first();
            if (isset($p)) {
                $p->delete();
            }
        }
    }
};
