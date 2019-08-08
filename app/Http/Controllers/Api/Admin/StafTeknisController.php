<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PengajuanPengujian;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifikasiStafTeknisNotification;

class StafTeknisController extends Controller
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

    public function getMasterData()
    {
        $masterPengujian = new \App\Repositories\MasterPengujian();

        return dtcApiResponse(200, $masterPengujian->all());
    }


    public function updateDataPemohon($regId, Request $request)
    {
        $pengajuan = new PengajuanPengujian($regId);

        $pemohon = $pengajuan->updateDataPemohon($request);

        return dtcApiResponse(200, $pemohon);
    }

    public function updateDetail($regId, Request $request)
    {
        $pengajuan = new PengajuanPengujian($regId);

        $detail = $pengajuan->updateDetail($request);

        return dtcApiResponse(200, $detail);
    }

    public function updateBiayaTambahan($regId, Request $request)
    {
        $pengajuan = new PengajuanPengujian($regId);

        $biayaTambahan = $pengajuan->updateBiayaTambahan($request);

        return dtcApiResponse(200, $biayaTambahan);
    }

    public function storeBiayaTambahan($regId, Request $request)
    {
        $pengajuan = new PengajuanPengujian($regId);
        $biayaTambahan = $pengajuan->storeBiayaTambahan($request);
        return dtcApiResponse(200,$biayaTambahan);
    }

    public function verifikasiPengajuan($regId)
    {
        $pengajuan =  new PengajuanPengujian($regId);
        $_pengajuan = $pengajuan->verifikasi(4);
        \App\Repositories\ProsesPengajuan::make(4, $regId);
        Notification::send($pengajuan->masterPengajuanPengujian->first()->users, new VerifikasiStafTeknisNotification($pengajuan->masterPengajuanPengujian->first()));

        return dtcApiResponse(200, $_pengajuan);
    }



}
