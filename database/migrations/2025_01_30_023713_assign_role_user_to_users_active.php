<?php

use App\Models\Role;
use App\Models\User;
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
        $r = Role::firstWhere('name', 'like', 'Usuario');
        if ($r != null) {
            $users = User::where('active', true)->whereHas('books')->get();
            foreach ($users as $u) {
                $u->roles()->syncWithoutDetaching([$r->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
};
