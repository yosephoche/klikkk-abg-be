<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDetailPengajuanPengujianAddForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_pengajuan_pengujian', function (Blueprint $table) {
            $table->foreign('id_pengajuan_pengujian')->references('id')->on('pengajuan_pengujian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_pengajuan_pengujian', function (Blueprint $table) {
            $table->dropForeign('detail_pengajuan_pengujian_id_pengajuan_pengujian_foreign');
        });
    }
}
