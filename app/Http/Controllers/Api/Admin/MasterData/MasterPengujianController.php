<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MasterPengujian;

class MasterPengujianController extends Controller
{
    protected $master_pengujian;

    public function __construct()
    {
        $this->master_pengujian = new MasterPengujian();
    }

    public function index()
    {
        return dtcApiResponse(200, $this->master_pengujian->all());
    }

    public function storeJenisPengujian(Request $request){
        return $this->master_pengujian->storeJenisPengujian($request);
    }

    public function storeParameter(Request $request){
        $master_pengujian = $this->master_pengujian->getJenisPengujian($request->id_jenis_pengujian);

        return $master_pengujian->storeParameter($request);
    }

    public function updateJenisPengujian(Request $request){
        $master_pengujian = $this->master_pengujian->getJenisPengujian($request->id_jenis_pengujian);

        return $master_pengujian->updateJenisPengujian($request);
    }

    public function updateParameter(Request $request){
        $master_pengujian = $this->master_pengujian->getJenisPengujian($request->id_jenis_pengujian);

        return $master_pengujian->updateParameter($request);
    }

    public function delete(Request $request){
        $master_pengujian = $this->master_pengujian->getJenisPengujian($request->id_jenis_pengujian);

        return $master_pengujian->delete();
    }
}
