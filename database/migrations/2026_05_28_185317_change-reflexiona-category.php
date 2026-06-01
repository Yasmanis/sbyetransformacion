<?php

use App\Models\SchoolSection;
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
        SchoolSection::where('category', 'reflexiona')->update([
            'category' => 'reflection'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        SchoolSection::where('category', 'reflection')->update([
            'category' => 'reflexiona'
        ]);
    }
};
