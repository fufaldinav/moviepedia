<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmdbMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('tmdb_movies', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->boolean('adult');
            $table->string('backdrop_path')->nullable();
            $table->unsignedBigInteger('collection_id')->nullable();
            $table->integer('budget');
            $table->string('homepage')->nullable();
            $table->string('imdb_id')->nullable();
            $table->unsignedBigInteger('original_language_id');
            $table->string('original_title');
            $table->text('overview')->nullable();
            $table->float('popularity');
            $table->string('poster_path')->nullable();
            $table->date('release_date');
            $table->integer('revenue');
            $table->integer('runtime')->nullable();
            $table->string('status');
            $table->string('tagline')->nullable();
            $table->string('title');
            $table->bool('video');
            $table->float('vote_average');
            $table->integer('vote_count');
            $table->timestamps();
        });

        Schema::table('tmdb_movies', function (Blueprint $table) {
            $table->foreign('id')->references('id')->on('movies');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tmdb_movies');
    }
}
