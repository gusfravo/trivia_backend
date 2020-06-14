<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFacebook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('facebooks', function (Blueprint $table) {
        $table->increments('id')->index();
        $table->text('username'); // tiempo en milisegundos
        $table->text('access_token')->nullable();
        $table->text('userid')->nullable();
        $table->text('name');
        $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('facebooks');
    }
}
