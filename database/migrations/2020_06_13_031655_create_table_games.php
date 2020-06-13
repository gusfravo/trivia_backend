<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
          $table->increments('id')->index();
          $table->bigInteger('time'); // tiempo en milisegundos
          $table->dateTime('start')->nullable();
          $table->dateTime('end')->nullable();
          $table->string('status',255);
          $table->integer('trivia_id')->unsigned();
          $table->integer('profile_id')->unsigned();
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
        Schema::dropIfExists('games');
    }
}
