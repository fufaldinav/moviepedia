<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmdbCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmdb_companies', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->text('description');
            $table->string('headquarters');
            $table->string('homepage');
            $table->string('logo_path');
            $table->string('name');
            $table->unsignedBigInteger('origin_country');
            $table->unsignedBigInteger('parent_company')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmdb_companies');
    }
}
