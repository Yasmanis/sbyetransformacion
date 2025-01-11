<?php

use App\Models\File;
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
        Schema::table('file', function (Blueprint $table) {
            $table->timestamp('public_date')->nullable()->after('public_access');
        });

        $files = File::all();
        foreach ($files as $f) {
            if ($f->public_access) {
                $f->public_date = $f->updated_at;
                $f->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file', function (Blueprint $table) {
            $table->dropColumn('public_date');
        });
    }
};
