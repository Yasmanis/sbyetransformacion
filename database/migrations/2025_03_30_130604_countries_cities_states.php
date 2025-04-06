<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use App\Models\Country;
use App\Models\City;
use App\Models\State;

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

    public function setCountries()
    {
        $countries = $this->getJsonFileAsArray('countries');
        $name = null;
        foreach ($countries as $c) {
            $name = $c->name;
            $trans = $c->translations;
            if (isset($trans) && isset($trans->es)) {
                $name = $trans->es;
            }
            Country::create([
                'id' => $c->id,
                'name' => $name,
                'phonecode' => str_replace(' and', ', ', $c->phonecode),
                'timezones' => $c->timezones
            ]);
        }
    }

    public function setStates()
    {
        $states = $this->getJsonFileAsArray('states');
        foreach ($states as $s) {
            State::create([
                'id' => $s->id,
                'name' => $s->name,
                'country_id' => $s->country_id
            ]);
        }
    }

    public function setCities()
    {
        $cities = $this->getJsonFileAsArray('cities');
        foreach ($cities as $s) {
            City::create([
                'id' => $s->id,
                'name' => $s->name,
                'country_id' => $s->country_id,
                'state_id' => $s->state_id
            ]);
        }
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phonecode')->nullable();
            $table->text('timezones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $this->setCountries();

        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name', 100);
            $table->timestamps();
            $table->softDeletes();
        });

        $this->setStates();

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('state_id')->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name', 100);
            $table->timestamps();
            $table->softDeletes();
        });

        $this->setCities();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
    }
};