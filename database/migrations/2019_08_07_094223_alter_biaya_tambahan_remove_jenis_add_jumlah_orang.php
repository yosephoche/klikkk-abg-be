<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBiayaTambahanRemoveJenisAddJumlahOrang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biaya_tambahan', function (Blueprint $table) {
            $table->dropColumn('jenis_pengajuan');
            $table->smallInteger('jumlah_orang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biaya_tambahan', function (Blueprint $table) {
            $table->enum('jenis_pengajuan',['pengujian','pelatihan']);
            $table->dropColumn('jumlah_orang');
        });
    }
}
