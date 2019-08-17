<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSurveyResultsAddAnswerColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_results', function (Blueprint $table) {
            $table->enum('answer', ['sangat_puas','puas','tidak_puas'])->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_results', function (Blueprint $table) {
            $table->dropColumn('answer');
        });
    }
}
