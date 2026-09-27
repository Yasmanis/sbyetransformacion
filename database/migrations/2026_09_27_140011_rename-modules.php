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
        $m = Module::firstWhere('singular_label', 'Publicaciones');
        if ($m) {
            $m->singular_label = 'Publicar';
            $m->plural_label = 'Publicar';
            $m->save();
        }
        $m = Module::firstWhere('singular_label', 'Plataformas');
        if ($m) {
            $m->singular_label = 'Publicaciones';
            $m->plural_label = 'Publicaciones';
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
            $m->singular_label = 'Plataformas';
            $m->plural_label = 'Plataformas';
            $m->save();
        }
        $m = Module::firstWhere('singular_label', 'Publicar');
        if ($m) {
            $m->singular_label = 'Publicaciones';
            $m->plural_label = 'Publicaciones';
            $m->save();
        }
    }
};
