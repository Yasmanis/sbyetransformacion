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
            $table->string('book_volume')->nullable()->after('section_id');
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('book_volume')->nullable()->after('user_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->json('book_volumes')->nullable()->after('configuration');
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
            $table->dropColumn('book_volume');
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('book_volume');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('book_volumes');
        });
    }
};
