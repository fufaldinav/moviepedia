<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmdbMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('tmbd_movies', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->boolean('adult');
            $table->string('backdrop_path')->nullable();
            $table->unsignedBigInteger('belongs_to_collection')->nullable();
            $table->integer('budget');
            $table->string('homepage')->nullable();
            $table->string('imdb_id')->nullable();
            $table->unsignedBigInteger('original_language');
            $table->string('original_title');
            $table->text('overview')->nullable();
            $table->float('popularity');
            $table->string('poster_path')->nullable();
//            $table->string('production_countries');
            $table->date('release_date');
            $table->integer('revenue');
            $table->integer('runtime')->nullable();
//            $table->string('spoken_languages');
            $table->string('status');
            $table->string('tagline')->nullable();
            $table->string('title');
            $table->boolean('video');
            $table->float('vote_average');
            $table->integer('vote_count');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tmbd_movies');
    }
}
