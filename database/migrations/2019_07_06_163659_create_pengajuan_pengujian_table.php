<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengajuanPengujianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_pengujian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('nama_pemohon');
            $table->string('nama_perusahaan');
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->string('email');
            $table->string('jenis_usaha')->nullable();
            $table->string('rencana_lokasi_pengujian')->nullable();
            $table->string('tujuan_pengujian');
            $table->string('e_billing')->nullable();
            $table->enum('status_pengajuan', ['aktif','tidak aktif', 'draft'])->default('aktif');
            $table->smallInteger('tahap_pengajuan')->unsigned();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('pengajuan_pengujian');
    }
}
