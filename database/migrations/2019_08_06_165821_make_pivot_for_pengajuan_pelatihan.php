<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakePivotForPengajuanPelatihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_pelatihan_pengajuan_pelatihan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jenis_pelatihan_id');
            $table->string('pengajuan_pelatihan_id');
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
        Schema::dropIfExists('jenis_pelatihan_pengajuan_pelatihan');
    }
}
