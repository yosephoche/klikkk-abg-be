<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPengajuanPengujianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pengajuan_pengujian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_pengajuan_pengujian')->unsigned();
            $table->bigInteger('id_parameter_pengajuan')->unsigned();
            $table->integer('jumlah_titik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pengajuan_pengujian');
    }
}
