<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTahapPengajuanPengujianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahap_pengajuan_pengujian', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('nama');
            $table->smallInteger('urutan');
            $table->bigInteger('pic');
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
        Schema::dropIfExists('tahap_pengajuan');
    }
}
