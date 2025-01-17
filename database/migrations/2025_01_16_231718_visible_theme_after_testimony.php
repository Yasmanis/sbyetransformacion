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
        Schema::table('school_topics', function (Blueprint $table) {
            $table->boolean('visible_after_testimony')->after('book_volume')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_topics', function (Blueprint $table) {
            $table->dropColumn('visible_after_testimony');
        });
    }
};
