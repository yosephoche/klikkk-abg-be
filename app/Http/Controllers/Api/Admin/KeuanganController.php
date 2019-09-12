<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PengajuanPengujian;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InputEbillingNotification;
use App\Notifications\KonfirmasiKeuanganNotification;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->filter);
        $pengajuanPengujian = new PengajuanPengujian();
        $daftarPengajuan = $pengajuanPengujian->getListPengajuan($request, $request->filter);

        return dtcApiResponse(200, $daftarPengajuan);
    }

    public function riwayat(Request $request)
    {
        return dtcApiResponse(200, PengajuanPengujian::riwayat(6, $request));
    }

    public function inputEbilling($regId, Request $request)
    {
        $pengajuanPengujian = new PengajuanPengujian($regId);
        $pengajuanPengujian->updateEbilling($request);

        $pengajuanPengujian->verifikasi(7);
        \App\Repositories\ProsesPengajuan::make(7, $request->regId);

        Notification::send( $pengajuanPengujian->masterPengajuanPengujian->first()->users, new InputEbillingNotification($pengajuanPengujian->masterPengajuanPengujian->first()) );

        return dtcApiResponse(200, true);
    }

    public function uploadEbilling($regId, Request $request)
    {
        $pengajuanPengujian = new PengajuanPengujian($regId);
        $pengajuanPengujian->uploadEbilling($request);

        $pengajuanPengujian->verifikasi(7);
        \App\Repositories\ProsesPengajuan::make(7, $request->regId);

        Notification::send( $pengajuanPengujian->masterPengajuanPengujian->first()->users, new InputEbillingNotification($pengajuanPengujian->masterPengajuanPengujian->first()) );

        return dtcApiResponse(200, true);
    }

    public function show($regId)
    {
        $pengajuan =  PengajuanPengujian::getOne($regId);

        return dtcApiResponse(200, $pengajuan);
    }

    public function konfirmasiPembayaran($regId)
    {
        $pengajuanPengujian = new PengajuanPengujian($regId);

        $pengajuanPengujian->verifikasi(9);
        \App\Repositories\ProsesPengajuan::make(9, $regId);

        Notification::send( $pengajuanPengujian->masterPengajuanPengujian->first()->users, new KonfirmasiKeuanganNotification($pengajuanPengujian->masterPengajuanPengujian->first()) );

        return dtcApiResponse(200, null);
    }
}
