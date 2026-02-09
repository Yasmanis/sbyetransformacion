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
        Schema::create('contact_admin_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('size');
            $table->string('type');
            $table->string('path');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('contact_admins')->onDelete('cascade');
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
        Schema::dropIfExists('contact_admin_attachments');
    }
};
