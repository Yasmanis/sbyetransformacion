<?php

use App\Models\Contact;
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
        Schema::table('contacts', function (Blueprint $table) {
            $table->json('book_volumes')->nullable()->after('user_id');
        });
        $contacts = Contact::all();
        foreach ($contacts as $c) {
            $c->book_volumes = [$c->book_volume];
            $c->save();
        }
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('book_volume');
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
            $table->dropColumn('book_volumes');
        });
    }
};