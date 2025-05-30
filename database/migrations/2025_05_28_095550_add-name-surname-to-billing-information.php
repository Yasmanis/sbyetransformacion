<?php

use App\Models\BillingInformation;
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
        Schema::table('users_billing_information', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('surname')->nullable()->after('name');
        });

        $data = BillingInformation::all();
        foreach ($data as $d) {
            $d->name = $d->user->name;
            $d->surname = $d->user->surname;
            $d->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_billing_information', function (Blueprint $table) {
            $table->dropColumn('name', 'surname');
        });
    }
};