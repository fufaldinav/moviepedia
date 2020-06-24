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
            $table->string('poster_path');
            $table->string('backdrop_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tmdb_collections');
    }
}
