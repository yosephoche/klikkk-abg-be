<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterJenisPengujianSetUrutanToUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_pengujian', function (Blueprint $table) {
            $table->smallInteger('urutan')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_pengujian', function (Blueprint $table) {
            $table->smallInteger('urutan')->change();
        });
    }
}
