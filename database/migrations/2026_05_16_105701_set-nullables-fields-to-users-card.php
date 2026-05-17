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
        Schema::table('users_buyers', function (Blueprint $table) {
            $table->dropForeign('users_buyers_country_id_foreign');
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null');
            $table->string('province')->nullable()->change();
            $table->string('genre')->nullable()->change();
            $table->string('birthdate')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_buyers', function (Blueprint $table) {});
    }
};
