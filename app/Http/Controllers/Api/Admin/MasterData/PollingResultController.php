<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Polling;
use App\Models\PollingResult;

class PollingResultController extends Controller
{
    public function index()
    {
        $polling = Polling::with('result')->get();

        $result = $polling->map(function($value){
            return [
                'id' => $value->id,
                'question' => $value->question,
                'user_count' => $value->result->count(),
                'sangat_puas' => $value->result->where('answer','sangat_puas')->count(),
                'puas' => $value->result->where('answer','puas')->count(),
                'biasa_saja' => $value->result->where('answer','biasa_saja')->count(),
                'kurang' => $value->result->where('answer','kurang')->count(),
                'tidak_puas' => $value->result->where('answer','tidak_puas')->count(),
            ];
        });

        return dtcApiResponse(200, $result);
    }

    public function show($pollingId)
    {
        $polling = Polling::where('id',$pollingId);
        $polling = $polling->with('result')->get();

        $result = $polling->map(function($value){
            return [
                'id' => $value->id,
                'question' => $value->question,
                'user_count' => $value->result->count(),
                'sangat_puas' => $value->result->where('answer','sangat_puas')->count(),
                'puas' => $value->result->where('answer','puas')->count(),
                'biasa_saja' => $value->result->where('answer','biasa_saja')->count(),
                'kurang' => $value->result->where('answer','kurang')->count(),
                'tidak_puas' => $value->result->where('answer','tidak_puas')->count(),
            ];
        });

        return dtcApiResponse(200, $result);
    }
}
