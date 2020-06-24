<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryMovieTable extends Migration
{
    public function up()
    {
        Schema::create('country_movie', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('movie_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('country_movie');
    }
}
