<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResult extends Model
{
    protected $table = 'survey_results';
    protected $fillable = ['question_id', 'user_id'];

}
