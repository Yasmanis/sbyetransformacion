<?php

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
        Schema::create('shopping', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->float('amount')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('shopping_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shopping_id');
            $table->foreign('shopping_id')->references('id')->on('shopping')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('total');
            $table->float('amount')->default(0);
            $table->timestamps();
        });

        $module = Module::firstWhere('model', 'Buy');
        $module->model = 'Shopping';
        $module->base_url = '/admin/shopping';
        $module->save();

        $permissions = $module->permissions;
        foreach ($permissions as $p) {
            $p->name = str_replace('buy', 'shopping', $p->name);
            $p->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopping_products');
        Schema::dropIfExists('shopping');

        $module = Module::firstWhere('model', 'Shopping');
        $module->model = 'Buy';
        $module->base_url = '/admin/buys';
        $module->save();

        $permissions = $module->permissions;
        foreach ($permissions as $p) {
            $p->name = str_replace('buy', 'shopping', $p->name);
            $p->save();
        }
    }
};
