<?php

use App\Models\Module;
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
        try {
            Schema::table('users_buyers', function (Blueprint $table) {
                $table->string('city')->after('country_id');
                $table->string('province')->after('city');
            });
            Schema::table('users_buyers', function (Blueprint $table) {
                $table->dropConstrainedForeignId('state_id');
                $table->dropConstrainedForeignId('city_id');
            });
        } catch (\Throwable $th) {
            //throw $th;
        }
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
        Module::whereIn('model', ['State', 'City'])->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_buyers', function (Blueprint $table) {
            $table->dropColumn('city', 'province');
        });
    }
};
