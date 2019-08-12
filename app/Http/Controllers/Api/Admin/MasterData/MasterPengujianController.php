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

    public function saveParameter(Request $request)
    {
        return $this->master_pengujian->saveParameter($request->id_jenis_pengujian, $request);
    }

    public function savePeraturan(Request $request)
    {
        return $this->master_pengujian->storePeraturan($request);
    }

    public function updatePeraturan(Request $request)
    {
        return $this->master_pengujian->updatePeraturan($request);
    }

    public function deletePeraturan(Request $request)
    {
        return $this->master_pengujian->deletePeraturan($request);
    }

    public function editPeraturan($id)
    {
        return $this->master_pengujian->editPeraturan($id);
    }

    public function deleteParameter(Request $request)
    {
        return $this->master_pengujian->deleteParameter($request->uuid);
    }

    public function updateParameter(Request $request){
        return $this->master_pengujian->updateParameter($request->uuid, $request);
    }

    public function delete(Request $request){
        $master_pengujian = $this->master_pengujian->getJenisPengujian($request->id_jenis_pengujian);

        return $master_pengujian->delete();
    }

    public function edit($uuid)
    {
        return $this->master_pengujian->getParameter($uuid);

    }
}
