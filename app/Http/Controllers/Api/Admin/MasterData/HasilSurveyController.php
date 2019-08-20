<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use App\Exceptions\DataNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SurveyQuestion;

class HasilSurveyController extends Controller
{
    public function index()
    {
        $result = SurveyQuestion::with(['user','surveyResult'])->get();

        $result = $result->map(function($value){
            return [
                'id' => $value->id,
                'question' => $value->question,
                'user_count' => $value->user->count(),
                'sangat_puas' => $value->surveyResult->where('answer','sangat_puas')->count(),
                'puas' => $value->surveyResult->where('answer','puas')->count(),
                'tidak_puas' => $value->surveyResult->where('answer','tidak_puas')->count(),
            ];
        });

        return dtcApiResponse(200, $result);
    }

    public function show($questionId)
    {
        $survey = SurveyQuestion::where('id' ,$questionId);

        if ($survey->with(['user','surveyResult'])->first() == 0) {
            throw new DataNotFoundException('Hasil survey tidak di temukan');
        }

        $survey = $survey->with(['user','surveyResult'])->first();
        $result =
             [
                'id' => $survey->id,
                'question' => $survey->question,
                'user_count' => $survey->user->count(),
                'sangat_puas' => $survey->surveyResult->where('answer','sangat_puas')->count(),
                'puas' => $survey->surveyResult->where('answer','puas')->count(),
                'tidak_puas' => $survey->surveyResult->where('answer','tidak_puas')->count(),
            ];

        return dtcApiResponse(200, $result);
    }
}
