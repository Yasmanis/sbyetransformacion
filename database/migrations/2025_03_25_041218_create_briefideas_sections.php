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
        Schema::create('briefideas_sections', function (Blueprint $table) {
            $table->unsignedBigInteger('briefidea_id');
            $table->foreign('briefidea_id')->references('id')->on('brief_ideas')->onDelete('cascade');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('categories_nomenclatures')->onDelete('cascade');
        });

        Schema::table('brief_ideas', function (Blueprint $table) {
            $table->dropForeign('brief_ideas_message_id_foreign');
        });

        Schema::table('brief_ideas', function (Blueprint $table) {
            $table->foreign('message_id')->references('id')->on('push_messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('briefideas_sections');
    }
};