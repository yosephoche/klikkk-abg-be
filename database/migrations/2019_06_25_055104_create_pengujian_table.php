<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengujianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengujian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('nama_pemohon');
            $table->string('nama_perusahaan');
            $table->text('alamat');
            $table->string('no_telepon');
            $table->string('email');
            $table->string('jenis_usaha')->nullable();
            $table->string('rencana_lokasi_pengujian')->nullable();
            $table->string('tujuan_pengujian');
            $table->string('e_billing')->nullable();
            $table->enum('status_pengujian', ['aktif','draft']);
            $table->bigInteger('tahap_pengajuan')->unsigned();
            $table->longText('keterangan')->nullable();
            $table->double('total_biaya')->nullable();
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
        Schema::dropIfExists('pengujian');
    }
}
