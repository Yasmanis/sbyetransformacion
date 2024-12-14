<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schoolchat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('id')->on('school_topics')->onDelete('cascade');
            $table->unsignedBigInteger('from_id');
            $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('reply_to')->nullable();
            $table->foreign('reply_to')->references('id')->on('schoolchat')->onDelete('cascade');
            $table->text('message');
            $table->boolean('from_visible')->default(false);
            $table->boolean('from_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('schoolchat_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->unsignedBigInteger('chat_id');
            $table->foreign('chat_id')->references('id')->on('schoolchat')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('schoolchat_users', function (Blueprint $table) {
            $table->unsignedBigInteger('chat_id');
            $table->foreign('chat_id')->references('id')->on('schoolchat')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('schoolchat_react', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('chat_id');
            $table->foreign('chat_id')->references('id')->on('schoolchat')->onDelete('cascade');
        });

        Schema::create('schoolchat_highligth', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('chat_id');
            $table->foreign('chat_id')->references('id')->on('schoolchat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schoolchat_react');
        Schema::dropIfExists('schoolchat_highligth');
        Schema::dropIfExists('schoolchat_attachments');
        Schema::dropIfExists('schoolchat_users');
        Schema::dropIfExists('schoolchat');
    }
};