<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageMovieTable extends Migration
{
    public function up()
    {
        Schema::create('language_movie', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('movie_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('language_movie');
    }
}
