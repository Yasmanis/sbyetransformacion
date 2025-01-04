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
        Schema::create('private_msg_send', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('msg');
            $table->unsignedBigInteger('from_id');
            $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('private_msg_send')->onDelete('cascade');
            $table->unsignedBigInteger('to_id')->nullable();
            $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('delete_by_from')->default(false);
            $table->boolean('delete_by_to')->default(false);
            $table->boolean('read_by_to')->default(false);
            $table->boolean('highlight_by_to')->default(false);
            $table->timestamps();
        });

        Schema::create('private_msg_received', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('message_id');
            $table->foreign('message_id')->references('id')->on('private_msg_send')->onDelete('cascade');
            $table->boolean('highlight')->default(false);
            $table->boolean('read')->default(false);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('private_msg_received')->onDelete('cascade');
        });

        Schema::create('private_msg_archived', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('message_id');
            $table->foreign('message_id')->references('id')->on('private_msg_send')->onDelete('cascade');
        });

        Schema::create('private_msg_deleted', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('message_id')->nullable();
            $table->foreign('message_id')->references('id')->on('private_msg_received')->onDelete('cascade');
        });

        Schema::create('private_msg_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('message_id');
            $table->foreign('message_id')->references('id')->on('private_msg_send')->onDelete('cascade');
            $table->json('note')->nullable();
        });

        Schema::create('private_msg_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->unsignedBigInteger('message_id');
            $table->foreign('message_id')->references('id')->on('private_msg_send')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('private_msg_attachments');
        Schema::dropIfExists('private_msg_notes');
        Schema::dropIfExists('private_msg_deleted');
        Schema::dropIfExists('private_msg_received');
        Schema::dropIfExists('private_msg_archived');
        Schema::dropIfExists('private_msg_send');
    }
};
