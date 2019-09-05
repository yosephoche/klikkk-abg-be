<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Polling;

class PollingController extends Controller
{
    public function showPolling()
    {
        $polling = Polling::all();
        return dtcApiResponse(200, $polling);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        $result = [];
        foreach ($request->question_id as $key => $value) {
            $result[$key] = new \App\Models\PollingResult();
            $result[$key]['polling_id'] = $value;
            $result[$key]['answer'] = $request['answer'][$key];
        }
        $user->pollingResult()->saveMany($result);

        return dtcApiResponse(200, null,'Terima kasih telah berpartisipasi dalam polling yang kami adakan.');
    }
}
