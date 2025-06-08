<?php

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Nette\Utils\Random;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('other_people');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('ticket_temp')->nullable()->after('book_date');
        });

        $contacts = Contact::all();
        foreach ($contacts as $c) {
            $user = User::where('email', $c->email)->first();
            if (!isset($user)) {
                $user = new User();
                $user->username = $c->email;
                $user->email = $c->email;
                $user->name = $c->name;
                $user->surname = $c->surname;
                $user->active = false;
                $user->password = Random::generate();
                $user->save();
            }
            $c->user_id = $user->id;
            $c->ticket_temp = $c->ticket;
            $c->save();
        }

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('name', 'surname', 'email', 'ticket');
        });

        Schema::table('contacts', function (Blueprint $table) {
            DB::statement('alter table contacts change ticket_temp ticket varchar(255)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('surname')->after('name');
            $table->string('email')->after('surname');
        });

        $contacts = Contact::all();
        foreach ($contacts as $c) {
            $user = User::find($c->user_id);
            if (isset($user)) {
                $c->name = $user->name;
                $c->surname = $user->surname;
                $c->email = $user->email;
                $c->save();
            }
        }

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
