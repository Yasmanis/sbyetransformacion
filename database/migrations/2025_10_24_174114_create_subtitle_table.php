<?php

use App\Models\Product;
use App\Models\ProductSubtitle;
use App\Models\Subtitle;
use Carbon\Carbon;
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
        Schema::create('subtitles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->morphs('subtitlable');
            $table->timestamps();
        });

        Schema::table('product_category', function (Blueprint $table) {
            $table->longText('description')->nullable()->after('name');
        });

        $subtitles = ProductSubtitle::all();
        $date = Carbon::now();
        $temp = [];
        foreach ($subtitles as $s) {
            $temp[] = [
                'name' => $s->name,
                'description' => $s->description,
                'subtitlable_type' => Product::class,
                'subtitlable_id' => $s->product_id,
                'created_at' => $date,
                'updated_at' => $date
            ];
        }
        if (count($temp) > 0) {
            Subtitle::insert($temp);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtitles');

        Schema::table('product_category', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
