<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->longText('end_text')->nullable()->after('description');
        });
        Schema::table('product_subcategory', function (Blueprint $table) {
            $table->longText('end_text')->nullable()->after('description');
        });

        DB::statement('ALTER TABLE product_subcategory MODIFY description longtext NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_category', function (Blueprint $table) {
            $table->dropColumn('end_text');
        });
        Schema::table('product_subcategory', function (Blueprint $table) {
            $table->dropColumn('end_text');
        });
    }
};
