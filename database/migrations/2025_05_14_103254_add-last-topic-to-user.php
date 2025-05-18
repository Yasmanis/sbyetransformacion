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
        Schema::create('users_last_courses', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('school_sections')->onDelete('cascade');
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('id')->on('school_topics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_last_courses');
    }
};
