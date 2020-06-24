<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMovieTable extends Migration
{
    public function up()
    {
        Schema::create('company_movie', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('movie_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_movie');
    }
}
