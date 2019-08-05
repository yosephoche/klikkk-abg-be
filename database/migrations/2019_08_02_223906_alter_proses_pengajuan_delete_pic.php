<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProsesPengajuanDeletePic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proses_pengajuan', function (Blueprint $table) {
            $table->dropColumn('pic');
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
            $table->bigInteger('pic');
        });
    }
}
