<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PengajuanPengujian;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InputEbillingNotification;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->filter);
        $pengajuanPengujian = new PengajuanPengujian();
        $daftarPengajuan = $pengajuanPengujian->getListPengajuan($request, $request->filter);

        return dtcApiResponse(200, $daftarPengajuan);
    }

    public function inputEbilling(Request $request)
    {
        $pengajuanPengujian = new PengajuanPengujian($request->regId);
        $pengajuanPengujian->updateEbilling($request);

        $pengajuanPengujian->verifikasi(7);
        \App\Repositories\ProsesPengajuan::make(7, $request->regId);

        Notification::send( $pengajuanPengujian->masterPengajuanPengujian->first()->users, new InputEbillingNotification($pengajuanPengujian->masterPengajuanPengujian->first()) );

        return dtcApiResponse(200, true);
    }

    public function konfirmasiPembayaran($regId)
    {
        // return
    }
}
