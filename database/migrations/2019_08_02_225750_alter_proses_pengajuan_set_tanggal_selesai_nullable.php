<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProsesPengajuanSetTanggalSelesaiNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proses_pengajuan', function (Blueprint $table) {
            $table->dateTime('tanggal_selesai')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proses_pengajuan', function (Blueprint $table) {
            $table->dateTime('tanggal_selesai')->change();
        });
    }
}
