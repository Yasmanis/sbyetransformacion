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
    protected $tables = ['product_subcategory'];

    public function up()
    {
        foreach ($this->tables as $t) {
            DB::statement('ALTER TABLE ' . $t . ' CHANGE image black_image varchar(255)');
            Schema::table($t, function (Blueprint $table) {
                $table->string('white_image')->nullable()->after('black_image');
            });
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
            DB::statement('ALTER TABLE ' . $t . ' CHANGE black_image image varchar(255)');
            Schema::table($t, function (Blueprint $table) {
                $table->dropColumn('white_image');
            });
        }
    }
};
