<?php
use Illuminate\Pagination\LengthAwarePaginator;

if (!function_exists('dtcApiResponse')) {
    function dtcApiResponse($code, $data, $message = null){
        $res_data = separatePagingAndData($data);
        $res_diag = httpResponse($code, $message);

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
            case 422:
                $status = 'UNPROCESSABLE ENTITY';
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
            else{
                $res = $data->toArray();
                $data = $res['data'];
                unset($res['pagination']);
                return ['data' => $data];
            }
        }else{
            return ['data' => $data];
        }
    }
}

if (!function_exists('responseMessage')) {
    function responseMessage($type = 'save', $status = 'success'){
        switch ($status) {
            case 'success':
                $message['status'] = 'Data berhasil';
                break;
            case 'error':
                $message['status'] = 'Data gagal';
                break;
        }

        switch ($type) {
            case 'save':
                $message['type'] = 'di simpan';
                break;
            case 'update':
                $message['type'] = 'di update';
                break;
            case 'delete':
                $message['type'] = 'di hapus';
                break;
        }

        return implode(' ', $message);
    }
}

if (!function_exists('databaseExceptionError')) {
    function databaseExceptionError($message){
        return dtcApiResponse(502,false,$message);
    }
}

if (!function_exists('prettyDate')) {
    function prettyDate($date)
    {
        if ($date) {
            $time = strtotime($date);
            return date('d', $time).' '.namaBulan(date('m', $time)).' '.date('Y', $time);
        }
        return null;
    }
}

if (!function_exists('namaBulan')) {
    function namaBulan($bulan)
    {
        $nama_bulan = [1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $nama_bulan[(int)$bulan];
    }
}

if (!function_exists('userAvatar')) {
    function userAvatar($avatar)
    {
        return $avatar?asset('storage/'.$avatar):null;
    }
}