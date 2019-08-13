<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\VerifikasiAkhirNotification;
use App\Repositories\PengajuanPengujian;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifikasiKabid;

class KepalaBidangController extends Controller
{
    public function index(Request $request)
    {
        $pengajuanPengujian = new PengajuanPengujian();
        $daftarPengajuan = $pengajuanPengujian->getListPengajuan($request, $request->filter);

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

        $_pengajuan = $pengajuan->verifikasi(5);
        \App\Repositories\ProsesPengajuan::make(5, $regId);

        Notification::send( $pengajuan->masterPengajuanPengujian->first()->users, new VerifikasiKabid($pengajuan->masterPengajuanPengujian->first()) );

        return dtcApiResponse(200, $_pengajuan);
    }

    public function revisiStafTeknis($regId)
    {
        $pengajuan =  new PengajuanPengujian($regId);
        $_pengajuan = $pengajuan->verifikasi(3);
        \App\Repositories\ProsesPengajuan::make(3, $regId);

        return dtcApiResponse(200, $_pengajuan);
    }

    public function verifikasiAkhir($regId)
    {
        $pengajuan =  new PengajuanPengujian($regId);

        $_pengajuan = $pengajuan->verifikasi(10);
        \App\Repositories\ProsesPengajuan::make(10, $regId);

        Notification::send( $pengajuan->masterPengajuanPengujian->first()->users, new VerifikasiAkhirNotification($pengajuan->masterPengajuanPengujian->first()) );

        return dtcApiResponse(200, $_pengajuan);
    }
}
