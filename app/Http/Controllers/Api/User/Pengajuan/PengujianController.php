<?php

namespace App\Http\Controllers\Api\User\Pengajuan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PengajuanPengujian;
use App\Http\Requests\StorePengajuanPengujian;

class PengujianController extends Controller
{

    public function getJenisPengujian()
    {
        return PengajuanPengujian::getAllJenisPengajuan();
    }

    public function getParameterPengujian(Request $request)
    {
        return PengajuanPengujian::getParameterPengujian($request);
    }

    public function store(Request $request)
    {
        $pengajuanPengujian = new PengajuanPengujian();
        return $pengajuanPengujian->store($request);
    }

}
