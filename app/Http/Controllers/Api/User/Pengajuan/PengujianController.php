<?php

namespace App\Http\Controllers\Api\User\Pengajuan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PengajuanPengujian;
use App\Http\Requests\StorePengajuanPengujian;
use App\Notifications\PengajuanBaruNotification;
use Illuminate\Support\Facades\Notification;

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
        $pengajuanPengujian = $pengajuanPengujian->store($request);

        $kepala_balai = new \App\Models\User();

        $kepala_balai = $kepala_balai->whereHas('roles', function($q){
            $q->where('name', 'kepala_balai');
        })->first();

        Notification::send($kepala_balai, new PengajuanBaruNotification($pengajuanPengujian['data_pemohon']['regId']));

        return dtcApiResponse(200, $pengajuanPengujian);
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

    public function kirim($regId)
    {
        $pengajuan =  new PengajuanPengujian($regId);
        $_pengajuan = $pengajuan->verifikasi(3);
        \App\Repositories\ProsesPengajuan::make(3, $regId);
        // Notification::send($pengajuan->masterPengajuanPengujian->first()->users, new VerifikasiStafTeknisNotification($pengajuan->masterPengajuanPengujian->first()));

        return dtcApiResponse(200, $_pengajuan);
    }

    public function setuju($regId)
    {
        $pengajuan =  new PengajuanPengujian($regId);
        $_pengajuan = $pengajuan->verifikasi(6);
        \App\Repositories\ProsesPengajuan::make(6, $regId);
        // Notification::send($pengajuan->masterPengajuanPengujian->first()->users, new VerifikasiStafTeknisNotification($pengajuan->masterPengajuanPengujian->first()));

        return dtcApiResponse(200, $_pengajuan);
    }

}
