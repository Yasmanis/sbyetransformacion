<?php

use App\Models\SchoolTopic;
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
        Schema::table('schoolchat', function (Blueprint $table) {
            if (!Schema::hasColumn('schoolchat', 'topicable_type')) {
                $table->morphs('topicable');
            }
        });

        DB::statement('update schoolchat set topicable_id = topic_id, topicable_type = ?', [SchoolTopic::class]);

        Schema::table('schoolchat', function (Blueprint $table) {
            if (Schema::hasColumn('schoolchat', 'topic_id')) {
                $table->dropConstrainedForeignId('topic_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
};
