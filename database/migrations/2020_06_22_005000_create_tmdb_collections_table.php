<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmdbCollectionsTable extends Migration
{
    public function up()
    {
        Schema::create('tmdb_collections', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name');
            $table->text('overview');
            $table->string('poster_path')->nullable();
            $table->string('backdrop_path');
            $table->timestamps();
        });

        Schema::table('tmdb_collections', function (Blueprint $table) {
            $table->foreign('id')->references('id')->on('collections');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tmdb_collections');
    }
}
