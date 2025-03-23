<?php

use App\Models\CategoryNomenclature;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $panels = ['escuela', 'posts', 'newsletters', 'conferencias'];
        foreach ($panels as $p) {
            CategoryNomenclature::create(
                [
                    'key' => 'panels',
                    'value' => $p
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        CategoryNomenclature::where('key', 'panels')->delete();
    }
};