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
        Schema::table('testimonies', function (Blueprint $table) {
            $table->string('name_to_show')->nullable()->after('type');
            $table->boolean('anonimous')->default(false)->after('name_to_show');
            $table->longText('msg_to_admin')->nullable()->after('anonimous');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('testimonies', function (Blueprint $table) {
            $table->dropColumn('name_to_show', 'anonimous', 'msg_to_admin');
        });
    }
};