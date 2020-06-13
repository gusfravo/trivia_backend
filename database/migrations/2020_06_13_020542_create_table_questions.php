<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('questions', function (Blueprint $table) {
        $table->increments('id')->index();
        $table->text('question');
        $table->integer('position');
        $table->text('img');
        $table->integer('trivia_id')->unsigned();
        $table->timestamps();
      });
      Schema::table('questions', function($table) {
          $table->foreign('trivia_id')->references('id')->on('trivias')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
