<?php

use App\Models\CategoryNomenclature;
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
        Schema::create('categories_nomenclatures', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('value');
            $table->timestamps();
        });

        $sections = ['ideas breves', 'recetas', 'recordatorios', 'analisis de alimentos'];

        foreach ($sections as $s) {
            $section = new CategoryNomenclature();
            $section->key = 'section';
            $section->value = $s;
            $section->save();
        }

        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate();
            $table->string('url')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        Schema::create('campaign_assigned_to', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnUpdate();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->timestamps();
        });

        Schema::create('campaigns_sections', function (Blueprint $table) {
            $table->unsignedBigInteger('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('categories_nomenclatures')->onDelete('cascade');
        });

        Schema::create('push_messages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('message')->nullable();
            $table->date('next')->nullable();
            $table->date('issued')->nullable();
            $table->date('end_date')->nullable();
            $table->string('periodicity')->nullable();
            $table->boolean('send')->default(false);
            $table->string('status')->nullable();
            $table->string('url')->nullable();
            $table->string('logo')->nullable();
            $table->string('action_button_url')->nullable();
            $table->string('action_button_title')->nullable();
            $table->unsignedBigInteger('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnUpdate();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate();
            $table->dateTime('scheduled_shipping_date')->nullable();
            $table->string('periodicity_after')->nullable();
            $table->string('periodicity_after_to')->nullable();
            $table->string('periodicity_hour')->nullable();
            $table->string('periodicity_frequency')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->json('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('push_messages_sections', function (Blueprint $table) {
            $table->unsignedBigInteger('message_id');
            $table->foreign('message_id')->references('id')->on('push_messages')->onDelete('cascade');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('categories_nomenclatures')->onDelete('cascade');
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
            'singular_label' => 'Mensaje',
            'plural_label' => 'Mensajes push',
            'model' => 'PushMessage',
            'ico' => 'mdi-bell-badge-outline',
            'base_url' => '/admin/push-messages',
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
        Schema::dropIfExists('push_messages_sections');
        Schema::dropIfExists('push_messages');
        Schema::dropIfExists('campaigns_sections');
        Schema::dropIfExists('campaign_assigned_to');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('categories_nomenclatures');
    }
};
