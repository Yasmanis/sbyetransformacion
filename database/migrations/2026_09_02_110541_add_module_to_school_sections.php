<?php

use App\Models\Module;
use App\Models\SchoolSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        Schema::table('school_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('school_sections', 'module_id')) {
                $table->unsignedBigInteger('module_id')->nullable()->after('order');
                $table->foreign('module_id')->references('id')->on('modules')->cascadeOnDelete();
            }
        });

        $sections = SchoolSection::all();
        foreach ($sections as $s) {
            $m = Module::firstWhere('model', $s->category);
            $s->module_id = $m->id;
            $s->save();
        }

        Schema::table('school_sections', function (Blueprint $table) {
            if (Schema::hasColumn('school_sections', 'category')) {
                $table->dropColumn('category');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('school_sections', 'category')) {
                $table->string('category')->nullable()->after('order');
            }
        });

        $sections = SchoolSection::all();
        foreach ($sections as $s) {
            $m = Module::find($s->module_id);
            $s->category = Str::lower($m->model);
            $s->save();
        }

        Schema::table('school_sections', function (Blueprint $table) {
            if (Schema::hasColumn('school_sections', 'module_id')) {
                $table->dropConstrainedForeignId('module_id');
            }
        });
    }
};
