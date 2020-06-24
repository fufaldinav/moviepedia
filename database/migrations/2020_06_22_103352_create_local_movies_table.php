<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('local_movies', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->boolean('adult');
            $table->string('original_title');
            $table->float('popularity');
            $table->boolean('video');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('local_movies');
    }
}
