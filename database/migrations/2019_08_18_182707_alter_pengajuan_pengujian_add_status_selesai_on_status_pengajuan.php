<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPengajuanPengujianAddStatusSelesaiOnStatusPengajuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE pengajuan_pengujian MODIFY COLUMN status_pengajuan ENUM('aktif', 'tidak aktif', 'draft', 'tolak','selesai')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE pengajuan_pengujian MODIFY COLUMN status_pengajuan ENUM('aktif', 'tidak aktif', 'draft', 'tolak')");
    }
}
