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
        Schema::table('users_payment_methods', function (Blueprint $table) {
            $table->unsignedBigInteger('billing_information_id')->nullable()->after('user_id');
            $table->foreign('billing_information_id')->references('id')->on('users_billing_information')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_payment_methods', function (Blueprint $table) {
            $table->dropConstrainedForeignId('billing_information_id');
        });
    }
};
