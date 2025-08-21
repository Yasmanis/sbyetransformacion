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
        $tables = ['products_offers', 'products_discount'];
        foreach ($tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->date('end_date')->nullable();
            });
            DB::statement(sprintf('update %s set end_date=end_at', $t));
            Schema::table($t, function (Blueprint $table) {
                $table->dropColumn('end_at');
            });
            Schema::table($t, function (Blueprint $table) {
                $table->date('end_at')->nullable()->after('start_at');
            });
            DB::statement(sprintf('update %s set end_at=end_date', $t));
            Schema::table($t, function (Blueprint $table) {
                $table->dropColumn('end_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
};
