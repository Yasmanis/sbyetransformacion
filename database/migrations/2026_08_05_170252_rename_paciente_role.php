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
        $role = Role::firstWhere('name', 'paciente');
        if ($role) {
            $role->name = 'consultante';
            $role->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $role = Role::firstWhere('name', 'consultante');
        if ($role) {
            $role->name = 'paciente';
            $role->save();
        }
    }
};
