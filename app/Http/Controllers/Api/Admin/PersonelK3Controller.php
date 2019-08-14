<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Pelaksanaan;
use App\Repositories\PengajuanPengujian;

class PersonelK3Controller extends Controller
{
    public function index(Request $request)
    {
        $pengajuanPengujian = new PengajuanPengujian();
        $daftarPengajuan = $pengajuanPengujian->getListPengajuan($request,'pelaksanaan');

        return dtcApiResponse(200, $daftarPengajuan);
    }

    public function pelaksanaan($regId)
    {
        $pelaksanaan = new Pelaksanaan($regId);

        return dtcApiResponse(200, $pelaksanaan->pelaksanaan());
    }

    public function mulai($regId,$tahap)
    {
        $pelaksanaan = new Pelaksanaan($regId);
        $pelaksanaan->mulai($tahap);
        return dtcApiResponse(200, $pelaksanaan->pengajuanPengujian);
    }

    public function selesai($regId, $tahap)
    {
        $pelaksanaan = new Pelaksanaan($regId);
        $pelaksanaan->selesai($tahap);
        return dtcApiResponse(200, $pelaksanaan->pengajuanPengujian);
    }
}
