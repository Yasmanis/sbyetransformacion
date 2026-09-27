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
        $mAdmin = $m = Module::firstWhere('singular_label', 'Administracion');
        $m = Module::firstWhere('singular_label', 'Publicaciones');
        if ($m && $mAdmin) {
            $m->parent_id = $mAdmin->id;
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
        $m = Module::firstWhere('singular_label', 'Publicaciones');
        if ($m) {
            $m->parent_id = null;
            $m->save();
        }
    }
};
