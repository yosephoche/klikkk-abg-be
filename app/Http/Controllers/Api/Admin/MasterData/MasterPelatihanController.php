<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MasterPelatihan;

class MasterPelatihanController extends Controller
{
    public function index()
    {
        $master_pelatihan = new MasterPelatihan();

        return $master_pelatihan->getAll();
    }

    public function store(Request $request){
        $master_pelatihan = new MasterPelatihan();

        return $master_pelatihan->save($request);
    }

    public function edit($uuid)
    {
        $master_pelatihan = new MasterPelatihan($uuid);
        return $master_pelatihan->edit();
    }

    public function update(Request $request)
    {
        $master_pelatihan = new MasterPelatihan($request->uuid);
        return $master_pelatihan->save($request);
    }

    public function delete(Request $request)
    {
        $master_pelatihan = new MasterPelatihan($request->uuid);
        return $master_pelatihan->delete();
    }
}
