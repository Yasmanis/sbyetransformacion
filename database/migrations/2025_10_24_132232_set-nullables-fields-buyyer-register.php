<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement('ALTER TABLE users_buyers MODIFY postal_code VARCHAR(255) NULL, MODIFY road VARCHAR(255) NULL, MODIFY address VARCHAR(255) NULL, MODIFY phone VARCHAR(255) NULL, MODIFY phone_code VARCHAR(255) NULL, MODIFY city VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
