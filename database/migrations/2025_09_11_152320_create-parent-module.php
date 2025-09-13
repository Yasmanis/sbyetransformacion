<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('modules', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('application_id');
            $table->foreign('parent_id')->references('id')->on('modules')->nullOnDelete();
            $table->smallInteger('order')->default(0)->after('parent_id');
            $table->boolean('exclude_childs')->default(0)->after('order');
        });

        DB::statement('ALTER TABLE modules 
        MODIFY model VARCHAR(255) NULL,
        MODIFY base_url VARCHAR(255) NULL,
        MODIFY to_str VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_id');
            $table->dropColumn(['order', 'exclude_childs']);
        });
    }
};
