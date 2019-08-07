<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengajuanPelatihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_pelatihans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_pemohon');
            $table->string('alamat');
            $table->string('email');
            $table->string('instansi');
            $table->string('telepon');
            $table->string('user_id');
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
        Schema::dropIfExists('pengajuan_pelatihans');
    }
}
