<?php

use App\Models\PasswordChangeNotification;
use App\Models\UserNotifications;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Notifications\DatabaseNotification;
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
        Schema::create('users_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('priority', ['Alta', 'Media', 'Baja']);
            $table->string('base_url')->nullable();
            $table->longText('description')->nullable();
            $table->string('code');
            $table->string('model')->nullable();
            $table->string('model_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        $notifications = PasswordChangeNotification::all();
        $db_notifications = DatabaseNotification::all();
        foreach ($notifications as $n) {
            $un = new UserNotifications();
            $un->title = $n->title;
            $un->priority = $n->priority;
            $un->base_url = $n->base_url;
            $un->description = $n->description;
            $un->user_id = $n->user_id;
            $un->created_at = $n->created_at;
            $un->updated_at = $n->updated_at;
            $un->code = 'password_change';
            $un->model = 'User';
            $un->model_id = json_decode($n)->user_id;
            $un->save();
            foreach ($db_notifications as $db) {
                if (collect($db->data)->contains('id', $n->id)) {
                    $db->data = [$un];
                    $db->save();
                    break;
                }
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
        Schema::dropIfExists('users_notifications');
    }
};
