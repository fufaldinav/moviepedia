<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('iso_639_1', 2)->unique();
            $table->string('iso_639_2', 3)->unique();
            $table->string('name');
        });

        Artisan::call('db:seed', ['--class' => LanguageSeeder::class]);
    }

    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
