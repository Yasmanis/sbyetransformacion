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
        $module = Module::firstWhere('model', 'Learning');
        if ($module) {
            $module->ico = 'images/icon/white-learning.png';
            $module->save();
        }

        $module = Module::firstWhere('model', 'School');
        if ($module) {
            $module->ico = 'images/icon/white-life.png';
            $module->ico_from_path = true;
            $module->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $module = Module::firstWhere('model', 'Learning');
        if ($module) {
            $module->ico = 'images/icon/emoji-free-learning.png';
            $module->save();
        }

        $module = Module::firstWhere('model', 'School');
        if ($module) {
            $module->ico = 'mdi-emoticon-outline';
            $module->ico_from_path = false;
            $module->save();
        }
    }
};
