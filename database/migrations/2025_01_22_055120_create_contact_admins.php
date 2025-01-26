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
        Schema::create('contact_admins', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->longText('description');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->enum('status', ['new', 'close'])->default('new');
            $table->unsignedBigInteger('revised_by')->nullable();
            $table->foreign('revised_by')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('contact_admins_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('size');
            $table->string('path');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('contact_admins')->cascadeOnDelete();
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
        Schema::dropIfExists('contact_admins_attachments');
        Schema::dropIfExists('contact_admins');
    }
};