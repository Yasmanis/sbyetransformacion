<?php

use App\Models\Testimony;
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
        $testimonies = Testimony::where('type', '!=', 'video')->whereNull('book_volume')->get();
        foreach ($testimonies as $t) {
            $t->book_volume = 'tomo_1';
            $t->save();
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
