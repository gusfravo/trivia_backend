<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGameAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_answers', function (Blueprint $table) {
          $table->boolean('correct');
          $table->integer('game_id')->unsigned();
          $table->integer('answer_id')->unsigned();
          $table->timestamps();
        });
        Schema::table('game_answers', function($table) {
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
        Schema::table('game_answers', function($table) {
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_answers');
    }
}
