<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPengajuanPengujianAddFilesUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_pengujian', function (Blueprint $table) {
            $table->string('berkas_proposal')->default(null);
            $table->string('berkas_kup')->default(null);
            $table->string('berkas_surat_pengantar')->default(null);
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
            $table->dropColumn('berkas_proposal');
            $table->dropColumn('berkas_kup');
            $table->dropColumn('berkas_surat_pengantar');
        });
    }
}
