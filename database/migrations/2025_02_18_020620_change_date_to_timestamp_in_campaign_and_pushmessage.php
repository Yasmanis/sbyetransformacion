<?php

use App\Models\PushMessage;
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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
            $table->timestamp('start_at')->nullable()->after('title');
            $table->timestamp('end_at')->nullable()->after('start_at');
        });

        Schema::table('push_messages', function (Blueprint $table) {
            $table->dropColumn(['issued', 'end_date', 'next']);
            $table->timestamp('start_at')->nullable()->after('message');
            $table->timestamp('next_at')->nullable()->after('start_at');
            $table->timestamp('end_at')->nullable()->after('next_at');
        });

        Schema::table('brief_ideas', function (Blueprint $table) {
            $table->unsignedBigInteger('message_id')->after('created_by');
            $table->foreign('message_id')->references('id')->on('push_messages')->cascadeOnUpdate();
            $table->dropColumn('data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['start_at', 'end_at']);
            $table->date('start_date')->nullable()->after('title');
            $table->date('end_date')->nullable()->after('start_date');
        });

        Schema::table('push_messages', function (Blueprint $table) {
            $table->dropColumn(['start_at', 'next_at', 'end_at']);
            $table->date('issued')->nullable()->after('message');
            $table->date('next')->nullable()->after('issued');
            $table->date('end_date')->nullable()->after('next');
        });

        Schema::table('brief_ideas', function (Blueprint $table) {
            $table->longText('data')->nullable();
            $table->dropConstrainedForeignId('message_id');
        });
    }
};