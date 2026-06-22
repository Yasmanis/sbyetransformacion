<?php

use App\Models\Role;
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
        $role = Role::firstWhere('name', 'contacto');
        if (!$role) {
            $role = new Role();
            $role->name = 'contacto';
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
        $role = Role::firstWhere('name', 'contacto');
        if ($role) {
            $role->forceDelete();
        }
    }
};
