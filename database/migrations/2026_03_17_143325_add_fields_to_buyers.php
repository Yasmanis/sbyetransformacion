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
            $table->longText('characteristics_img')->nullable()->after('birthdate');
            $table->string('nif_cif')->nullable()->after('birthdate');
            $table->longText('observations')->nullable()->after('birthdate');
            $table->longText('characteristics')->nullable()->after('birthdate');
            $table->longText('managers_dates')->nullable()->after('birthdate');
            $table->longText('managers_quotes')->nullable()->after('birthdate');
            $table->unsignedBigInteger('manager_id')->nullable()->after('birthdate');
            $table->foreign('manager_id')->references('id')->on('users')->nullOnDelete();
            $table->unsignedBigInteger('facilitator_id')->nullable()->after('birthdate');
            $table->foreign('facilitator_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_buyers', function (Blueprint $table) {
            $table->dropColumn(['nif_cif', 'observations', 'characteristics', 'managers_dates', 'managers_quotes', 'characteristics_img']);
            $table->dropConstrainedForeignId('manager_id');
            $table->dropConstrainedForeignId('facilitator_id');
        });
    }
};
