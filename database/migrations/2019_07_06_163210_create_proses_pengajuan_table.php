<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProsesPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proses_pengajuan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->enum('jenis_pengajuan', ['pengujian', 'pelatihan']);
            $table->bigInteger('id_pengajuan');
            $table->smallInteger('tahap_pengajuan')->unsigned();
            $table->bigInteger('pic')->unsigned();
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proses_pengajuan');
    }
}
