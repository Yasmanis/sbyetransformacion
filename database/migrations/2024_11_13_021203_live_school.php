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
        Schema::create('school_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('school_topics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coverImage')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('school_sections')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('school_resources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->boolean('principal')->default(false);
            $table->string('type');
            $table->string('duration_string')->nullable();
            $table->double('duration_number')->default(0);
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('id')->on('school_topics')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('school_users_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('resource_id');
            $table->foreign('resource_id')->references('id')->on('school_resources')->onDelete('cascade');
            $table->double('total_time')->default(0);
            $table->double('current_time')->default(0);
            $table->double('last_time')->default(0);
            $table->integer('percent')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_users_videos');
        Schema::dropIfExists('school_resources');
        Schema::dropIfExists('school_topics');
        Schema::dropIfExists('school_sections');
    }
};