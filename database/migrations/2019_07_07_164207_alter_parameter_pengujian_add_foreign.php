<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterParameterPengujianAddForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parameter_pengujian', function (Blueprint $table) {
            $table->foreign('id_jenis_pengujian')
                ->references('id')
                ->on('jenis_pengujian')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parameter_pengujian', function (Blueprint $table) {
            $table->dropForeign('parameter_pengujian_id_jenis_pengujian_foreign');
        });
    }
}
