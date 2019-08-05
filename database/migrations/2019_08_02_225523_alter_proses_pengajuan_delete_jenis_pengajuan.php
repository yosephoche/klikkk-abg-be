<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProsesPengajuanDeleteJenisPengajuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proses_pengajuan', function (Blueprint $table) {
            $table->dropColumn('jenis_pengajuan');
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
            $table->enum('jenis_pengajuan', ['pengujian', 'pelatihan']);
        });
    }
}
