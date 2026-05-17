<?php

use App\Models\Role;
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
        $r = Role::firstWhere('name', 'lector');
        if ($r) {
            $r->name = 'usuario';
            $r->save();
        }
        $r = Role::firstWhere('name', 'facilitador de procesos');
        if ($r) {
            $r->name = 'facilitador';
            $r->save();
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
