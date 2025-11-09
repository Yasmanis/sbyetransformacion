<?php

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
        Schema::table('product_category', function (Blueprint $table) {
            $table->string('image')->nullable()->after('name');
        });
        Schema::table('product_subcategory', function (Blueprint $table) {
            $table->string('image')->nullable()->after('name');
            $table->string('description')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_category', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('product_subcategory', function (Blueprint $table) {
            $table->dropColumn(['image', 'description']);
        });
    }
};
