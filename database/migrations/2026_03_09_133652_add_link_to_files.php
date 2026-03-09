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
            $table->string('link')->nullable()->after('type');
        });

        $files = File::where('type', 'link')->get();
        foreach ($files as $f) {
            $f->link = $f->name;
            $f->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $files = File::where('type', 'link')->get();
        foreach ($files as $f) {
            $f->name = $f->link;
            $f->save();
        }
        Schema::table('file', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
};
