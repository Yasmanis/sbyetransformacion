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
        $user = \App\Models\User::find(1);

        \App\Models\User::withoutEvents(function () use ($user) {
            $user->active = 1;
            $user->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $user = \App\Models\User::find(1);

        \App\Models\User::withoutEvents(function () use ($user) {
            $user->active = 0;
            $user->save();
        });
    }
};
