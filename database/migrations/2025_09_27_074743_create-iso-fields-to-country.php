<?php

use App\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    public function getJsonFileAsArray(string $fileName)
    {
        $data = File::get(__DIR__ . "/../data/$fileName.json");
        if (!$data) {
            return [];
        }

        return json_decode($data);
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('iso2')->nullable()->after('phonecode');
            $table->string('iso3')->nullable()->after('iso2');
        });
        $countries = $this->getJsonFileAsArray('countries');
        $countries_db = Country::all();
        $name = null;
        foreach ($countries_db as $cdb) {
            foreach ($countries as $c) {
                $name = $c->name;
                $trans = $c->translations;
                if (isset($trans) && isset($trans->es)) {
                    $name = $trans->es;
                }
                if ($cdb->name === $name) {
                    $cdb->iso2 = $c->iso2;
                    $cdb->iso3 = $c->iso3;
                    $cdb->save();
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
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn(['iso2', 'iso3']);
        });
    }
};
