<?php

use App\Models\Module;
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
        $m = Module::firstWhere('singular_label', 'Vivir en plenitud');
        if ($m) {
            $m->singular_label = 'video-libro';
            $m->plural_label = 'video-libro';
            $m->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $m = Module::firstWhere('singular_label', 'video-libro');
        if ($m) {
            $m->singular_label = 'Vivir en plenitud';
            $m->plural_label = 'Vivir en plenitud';
            $m->save();
        }
    }
};
