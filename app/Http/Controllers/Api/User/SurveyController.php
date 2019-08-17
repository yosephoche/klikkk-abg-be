<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SurveyQuestion;

class SurveyController extends Controller
{
    public function showSurvey()
    {
        $survey = SurveyQuestion::all();

        return dtcApiResponse(200, $survey);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        $result = [];
        foreach ($request->question_id as $key => $value) {
            $result[$key]['question_id'] = $value;
            $result[$key]['answer'] = $request['answer'][$key];
        }
        $user->survey()->attach($result);

        return dtcApiResponse(200, null,'Terima kasih telah berpartisipasi dalam survey yang kami adakan.');
    }
}
