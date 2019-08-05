<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeRepliesIdToNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_replies', function (Blueprint $table) {
            $table->bigInteger('replies_id')->unsigned()->nullable()->change(); 
            $table->bigInteger('topic_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_replies', function (Blueprint $table) {
            $table->bigInteger('topic_id')->unsigned()->change();
            $table->bigInteger('replies_id')->unsigned()->change();                        
        });
    }
}
