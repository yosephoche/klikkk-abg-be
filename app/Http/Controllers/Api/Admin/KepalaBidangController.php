<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PengajuanPengujian;

class KepalaBidangController extends Controller
{
    public function index(Request $request)
    {
        $pengajuanPengujian = new PengajuanPengujian();
        $daftarPengajuan = $pengajuanPengujian->getListPengajuan($request, 4);

        return dtcApiResponse(200, $daftarPengajuan);
    }

    public function show($regId)
    {
        $pengajuan =  PengajuanPengujian::getOne($regId);

        return dtcApiResponse(200, $pengajuan);
    }

    public function verifikasiPengajuan($regId)
    {
        $pengajuan =  new PengajuanPengujian($regId);
        $pengajuan = $pengajuan->verifikasi(5);
        \App\Repositories\ProsesPengajuan::make(5, $regId);

        return dtcApiResponse(200, $pengajuan);
    }
}
