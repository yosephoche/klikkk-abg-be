<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MasterPengujian;

class MasterPengujianController extends Controller
{
    public function index()
    {
        $master_pengujian = new MasterPengujian();
        return dtcApiResponse(200, $master_pengujian->all());
    }

    public function storeJenisPengujian(Request $request){
        $master_pengujian = new MasterPengujian();
        try {
            return dtcApiResponse(200, $master_pengujian->storeJenisPengujian($request), responseMessage('save', 'success'));
        } catch (\Illuminate\Database\QueryException $th) {
            return databaseExceptionError(implode(', ',$th->errorInfo));
        }
    }

    public function storeParameter(Request $request){
        $master_pengujian = new MasterPengujian($request->id_jenis_pengujian);

        try {
            return dtcApiResponse(200, $master_pengujian->storeParameter($request), responseMessage('save', 'success'));

        } catch (\Illuminate\Database\QueryException $th) {
            return databaseExceptionError(implode(', ',$th->errorInfo));
        }
    }

    public function updateJenisPengujian(Request $request){
        $master_pengujian = new MasterPengujian($request->id_jenis_pengujian);

        try {
            $master_pengujian->updateJenisPengujian($request);
            return dtcApiResponse(200, null,responseMessage('update','success'));
        } catch (\Illuminate\Database\QueryException $th) {
            return databaseExceptionError(implode(', ',$th->errorInfo));
        }
    }

    public function updateParameter(Request $request){
        $master_pengujian = new MasterPengujian($request->id_jenis_pengujian);

        try {
            $master_pengujian->updateParameter($request);
            return dtcApiResponse(200, null,responseMessage('update','success'));
        } catch (\Illuminate\Database\QueryException $th) {
            return databaseExceptionError(implode(', ',$th->errorInfo));
        }
    }

    public function delete(Request $request){
        $master_pengujian = new MasterPengujian($request->id_jenis_pengujian);

        try {
            $master_pengujian->delete();
            return dtcApiResponse(200, null,responseMessage('delete','success'));
        } catch (\Illuminate\Database\QueryException $th) {
            return databaseExceptionError(implode(', ',$th->errorInfo));
        }
    }
}
