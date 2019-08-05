<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPengajuanPengujianTableAddUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_pengujian', function (Blueprint $table) {
            $table->bigInteger('user')->unsigned()->after('total_biaya');

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
            $table->dropColumn('user');
        });
    }
}
