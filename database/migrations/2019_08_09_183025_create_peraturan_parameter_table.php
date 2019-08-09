<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeraturanParameterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peraturan_parameter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_jenis_pengujian')->unsigned();
            $table->string('peraturan');

            $table->foreign('id_jenis_pengujian')->references('id')->on('jenis_pengujian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peraturan_parameter');
    }
}
