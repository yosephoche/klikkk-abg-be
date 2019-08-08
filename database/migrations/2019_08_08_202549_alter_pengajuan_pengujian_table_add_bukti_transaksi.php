<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPengajuanPengujianTableAddBuktiTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_pengujian', function (Blueprint $table) {
            $table->string('bukti_transaksi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_pengujian', function (Blueprint $table) {
            $table->dropColumn('bukti_transaksi');
        });
    }
}
