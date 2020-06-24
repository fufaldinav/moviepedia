<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('iso_3166_1', 2)->unique();
            $table->string('name');
        });

        Artisan::call('db:seed', ['--class' => CountrySeeder::class]);
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
