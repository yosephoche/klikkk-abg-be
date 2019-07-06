<?php
use Illuminate\Pagination\LengthAwarePaginator;

if (!function_exists('dtcApiResponse')) {
    function dtcApiResponse($code, $data, $message = null){
        $res_data = separatePagingAndData($data);
        $res_diag = httpResponse($code, $message);

        // dd($res_data);

        return response(array_merge($res_data, $res_diag), 200);
    }
}

if (!function_exists('httpResponse')) {
    function httpResponse($code, $message){
        switch ($code) {
            case 200:
                $status = 'OK';
                break;
            case 401:
                $status = 'UNAUTORIZED';
                break;
            case 404:
                $status = 'NOT FOUND';
                break;
            case 500:
                $status = 'INTERNAL SERVER ERROR';
                break;
            case 502:
                $status = 'BAD GATEWAY';
                break;
        }

        return [
            'diagnostic' => [
                'status' => $status,
                'code' => $code,
                'message' => $message
            ]
        ];
    }
}

if (!function_exists('separatePagingAndData')) {
    function separatePagingAndData($data){
        if ($data instanceof LengthAwarePaginator) {
            if ($data->lastPage() > 1) {
                $res = $data->toArray();
                $data = $res['data'];
                unset($res['data']);
                return ['pagination' => $res, 'data' => $data];
            }
        }else{
            return ['data' => $data];
        }
    }
}
