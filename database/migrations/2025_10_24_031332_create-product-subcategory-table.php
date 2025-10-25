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
        Schema::create('product_subcategory', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->smallInteger('order')->default(0);
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('product_category')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('products_offers_category', function (Blueprint $table) {
            $table->id();
            $table->float('price')->default(0);
            $table->date('start_at');
            $table->date('end_at')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('product_category')->cascadeOnDelete();
            $table->longText('description');
            $table->timestamps();
        });

        Schema::create('products_offers_subcategory', function (Blueprint $table) {
            $table->id();
            $table->float('price')->default(0);
            $table->date('start_at');
            $table->date('end_at')->nullable();
            $table->unsignedBigInteger('subcategory_id');
            $table->foreign('subcategory_id')->references('id')->on('product_subcategory')->cascadeOnDelete();
            $table->longText('description');
            $table->timestamps();
        });

        Schema::create('products_discount_category', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->float('percent')->default(0);
            $table->float('income')->default(0);
            $table->date('start_at');
            $table->date('end_at')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('product_category')->cascadeOnDelete();
            $table->longText('description');
            $table->boolean('offers_income')->default(false);
            $table->timestamps();
        });

        Schema::create('products_discount_subcategory', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->float('percent')->default(0);
            $table->float('income')->default(0);
            $table->date('start_at');
            $table->date('end_at')->nullable();
            $table->unsignedBigInteger('subcategory_id');
            $table->foreign('subcategory_id')->references('id')->on('product_subcategory')->cascadeOnDelete();
            $table->longText('description');
            $table->boolean('offers_income')->default(false);
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('order');
            $table->foreign('category_id')->references('id')->on('product_category')->cascadeOnDelete();
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            $table->foreign('subcategory_id')->references('id')->on('product_subcategory')->cascadeOnDelete();
        });

        Schema::table('product_category', function (Blueprint $table) {
            $table->smallInteger('order')->default(0)->after('name');
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

        $app = Module::firstWhere('singular_label', 'tienda');

        $module = Module::create([
            'singular_label' => 'Subcategorias de productos',
            'plural_label' => 'Subcategorias de productos',
            'model' => 'ProductSubcategory',
            'ico' => 'mdi-sitemap-outline',
            'base_url' => '/admin/product-subcategories',
            'to_str' => 'name',
            'parent_id' => $app->id,
            'order' => 2
        ]);

        foreach ($permissions as $p) {
            $permission = new Permission();
            $permission->name = $p['code'] . '_' . Str::lower($module->model);
            $permission->label = $p['translate'];
            $permission->module_id = $module->id;
            $permission->save();
        }

        $modules = ['Product', 'ReasonForReturn', 'Country'];
        $index = 3;
        foreach ($modules as $mod) {
            $m = Module::firstWhere('model', $mod);
            $m->order = $index;
            $m->save();
            $index++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_discount_subcategory');
        Schema::dropIfExists('products_discount_category');
        Schema::dropIfExists('products_offers_subcategory');
        Schema::dropIfExists('products_offers_category');

        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropConstrainedForeignId('subcategory_id');
        });

        Schema::dropIfExists('product_subcategory');

        Schema::table('product_category', function (Blueprint $table) {
            $table->dropColumn('order');
        });

        $module = Module::firstWhere('model', 'ProductSubcategory');
        $module->delete();
    }
};
