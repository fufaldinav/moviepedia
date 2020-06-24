<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmdbCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('tmdb_companies', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->text('description');
            $table->string('headquarters');
            $table->string('homepage');
            $table->string('logo_path')->nullable();
            $table->string('name');
            $table->unsignedBigInteger('origin_country_id')->nullable();
            $table->unsignedBigInteger('parent_company_id')->nullable();
            $table->timestamps();
        });

        Schema::table('tmdb_companies', function (Blueprint $table) {
            $table->foreign('id')->references('id')->on('companies');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tmdb_companies');
    }
}
