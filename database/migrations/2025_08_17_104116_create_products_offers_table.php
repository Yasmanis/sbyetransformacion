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
        Schema::create('products_offers', function (Blueprint $table) {
            $table->id();
            $table->float('price')->default(0);
            $table->date('start_at');
            $table->date('end_at');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('products_discount', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->float('percent')->default(0);
            $table->float('income')->default(0);
            $table->date('start_at');
            $table->date('end_at');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
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
        Schema::dropIfExists('products_offers');
        Schema::dropIfExists('products_discount');
    }
};
