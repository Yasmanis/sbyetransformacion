<?php

use App\Models\Document;
use App\Models\User;
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
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumns('documents', ['sort_order'])) {
                $table->integer('sort_order')->default(0)->after('size');
            }
        });

        $users = User::all();
        foreach ($users as $u) {
            $documents = Document::accessibleBy($u->id)->select('parent_id')->distinct()->get();
            foreach ($documents as $folder) {
                Document::where('parent_id', $folder->parent_id)
                    ->orderBy('id')
                    ->get()
                    ->each(function ($doc, $index) {
                        $doc->sort_order = $index + 1;
                        $doc->saveQuietly();
                    });
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
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
