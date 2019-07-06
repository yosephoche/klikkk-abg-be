<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiayaTambahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biaya_tambahan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('jenis_pengajuan', ['pengujian', 'pelatihan']);
            $table->bigInteger('id_pengajuan');
            $table->string('nama_biaya');
            $table->double('biaya');
            $table->smallInteger('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('biaya_tambahan');
    }
}
