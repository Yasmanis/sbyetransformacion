<?php

use App\Models\Buyer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $users = User::doesntHave('buyer')->get();
        $buyers = [];
        $now = now();
        foreach ($users as $u) {
            $buyers[] = [
                'user_id' => $u->id,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }
        if (!empty($buyers)) {
            Buyer::insert($buyers);
        }
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
