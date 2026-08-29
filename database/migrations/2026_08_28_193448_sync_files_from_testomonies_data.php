<?php

use App\Models\Category;
use App\Models\File;
use App\Models\RecycleBin;
use App\Models\Testimony;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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
            if (!Schema::hasColumn('file', 'testimony_type')) {
                $table->string('testimony_type')->nullable()->after('fixed');
            }
            if (!Schema::hasColumn('file', 'message')) {
                $table->text('message')->nullable()->after('fixed');
            }
            if (!Schema::hasColumn('file', 'name_to_show')) {
                $table->string('name_to_show')->nullable()->after('fixed');
            }
            if (!Schema::hasColumn('file', 'anonimous')) {
                $table->boolean('anonimous')->default(false)->after('fixed');
            }
            if (!Schema::hasColumn('file', 'msg_to_admin')) {
                $table->text('msg_to_admin')->nullable()->after('fixed');
            }
            if (!Schema::hasColumn('file', 'amazon_image')) {
                $table->string('amazon_image')->nullable()->after('fixed');
            }
            if (!Schema::hasColumn('file', 'book_volume')) {
                $table->string('book_volume')->nullable()->after('fixed');
            }
            if (!Schema::hasColumn('file', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            }
        });

        $testimonies = DB::table('testimonies')->get();
        $category = Category::firstWhere('name', 'testimonios');
        foreach ($testimonies as $t) {
            $type = 'text';
            $size = null;
            $path = null;
            if ($t->type === 'video') {
                $type = Storage::mimeType('public/' . $t->message);
                $size = Storage::size('public/' . $t->message);
                $path = $t->message;
            }
            $data = [
                'name' => $t->title,
                'type' => $type,
                'testimony_type' => $t->type,
                'size' => $size,
                'path' => $path,
                'message' => $type === 'text' ? $t->message : null,
                'name_to_show' => $t->name_to_show,
                'anonimous' => $t->anonimous,
                'msg_to_admin' => $t->msg_to_admin,
                'user_id' => $t->user_id,
                'public_access' => $t->publicated,
                'public_date' => $t->publicated === 1 ? $t->updated_at : null,
                'order' => $t->order,
                'amazon_image' => $t->amazon_image,
                'book_volume' => $t->book_volume,
                'category_id' => $category->id,
                'created_at' => $t->created_at,
                'updated_at' => $t->updated_at,
            ];

            $obj = File::create($data);
            if ($t->deleted_at) {
                $obj->deleted_at = $t->deleted_at;
                $obj->save();
            }

            $rb = RecycleBin::where('recyclable_type', Testimony::class)->where('recyclable_id', $t->id)->first();
            if ($rb) {
                $rb->recyclable_id = $obj->id;
                $rb->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
};
