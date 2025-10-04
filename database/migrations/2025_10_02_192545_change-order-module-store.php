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
        $modules = ['ProductCategory', 'Product', 'ReasonForReturn', 'Country'];
        $index = 1;
        foreach ($modules as $mod) {
            $m = Module::firstWhere('model', $mod);
            $m->order = $index;
            $m->save();
            $index++;
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
