<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTahapPengajuanPengujianAddForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tahap_pengajuan_pengujian', function (Blueprint $table) {
            $table->bigInteger('pic')->unsigned()->change();

            $table->foreign('pic')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tahap_pengajuan_pengujian', function (Blueprint $table) {
            $table->bigInteger('pic')->change();

            $table->dropForeign('tahap_pengajuan_pengujian_pic_foreign');
        });
    }
}
