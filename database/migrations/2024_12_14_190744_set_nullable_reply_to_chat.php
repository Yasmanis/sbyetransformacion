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
        Schema::table('schoolchat', function (Blueprint $table) {
            $table->dropForeign(['reply_to']);
        });
        Schema::table('schoolchat', function (Blueprint $table) {
            $table->foreign('reply_to')->references('id')->on('schoolchat')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schoolchat', function (Blueprint $table) {
            $table->dropForeign(['reply_to']);
        });
        Schema::table('schoolchat', function (Blueprint $table) {
            $table->foreign('reply_to')->references('id')->on('schoolchat')->onDelete('cascade');
        });
    }
};
