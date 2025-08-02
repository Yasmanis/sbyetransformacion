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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('public')->default(false)->after('image');
            $table->smallInteger('valoration')->default(5)->after('public');
            $table->dropColumn(['first_payment', 'total_payments', 'total']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('total')->default(0)->after('price');
            $table->float('first_payment')->default(0)->after('total');
            $table->integer('total_payments')->default(0)->after('first_payment');
            $table->dropColumn(['public', 'valoration']);
        });
    }
};
