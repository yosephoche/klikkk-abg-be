<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDetailPengajuanPengujianTableChangeFieldName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_pengajuan_pengujian', function (Blueprint $table) {
            $table->renameColumn('id_parameter_pengajuan','id_parameter_pengujian');
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
            $table->renameColumn('id_parameter_pengujian','id_parameter_pengajuan');
        });
    }
}
