<?php

use App\Models\Module;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $modules = ['School', 'Learning'];
        foreach ($modules as $model) {
            $m = Module::firstWhere('model', $model);
            $permission = new Permission();
            $permission->name = sprintf('%s_%s', 'full', Str::lower($model));
            $permission->label = 'Ver sin restricciones';
            $permission->module_id = $m->id;
            $permission->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $modules = ['school', 'learning'];
        foreach ($modules as $model) {
            $permission = Permission::firstWhere('name', sprintf('%s_%s', 'full', Str::lower($model)));
            $permission->delete();
        }
    }
};
