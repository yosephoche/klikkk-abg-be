<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollingResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polling_result', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('polling_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->enum('answer', ['sangat_puas', 'puas', 'biasa_saja', 'kurang', 'tidak_puas']);
            $table->timestamps();

            $table->foreign('polling_id')->references('id')->on('polling')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polling_result');
    }
}
