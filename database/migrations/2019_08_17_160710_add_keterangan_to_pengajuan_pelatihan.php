<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeteranganToPengajuanPelatihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_pelatihans', function (Blueprint $table) {
            $table->text('komentar')->nullable()->after('telepon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_pelatihans', function (Blueprint $table) {
            $table->dropColumn('komentar');
        });
    }
}
