<?php

use App\Models\PushMessage;
use App\Models\PushMessageConfigNotification;
use App\Models\PushMessageFixedUser;
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
        Schema::dropIfExists('briefideas_sections');
        Schema::dropIfExists('brief_ideas');
        Schema::create('push_messages_fixed_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('message_id');
            $table->foreign('message_id')->references('id')->on('push_messages')->cascadeOnDelete();
            $table->boolean('fixed')->default(false);
        });
        Schema::create('push_messages_config_notification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('message_id');
            $table->foreign('message_id')->references('id')->on('push_messages')->cascadeOnDelete();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('push_messages_fixed_users');
        Schema::dropIfExists('push_messages_config_notification');
    }
};
