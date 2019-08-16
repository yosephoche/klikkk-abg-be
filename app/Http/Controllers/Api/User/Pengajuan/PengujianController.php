<?php

namespace App\Http\Controllers\Api\User\Pengajuan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PengajuanPengujian;
use App\Http\Requests\StorePengajuanPengujian;
use App\Notifications\PengajuanBaruNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\VerifikasiUserMail;
use App\Notifications\PengajuanDiSetujuiNotification;
use App\Notifications\PengajuanDiTolakNotification;
use App\Notifications\UploadBuktiTransaksiNotification;

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

    public function draft(Request $request)
    {
        $pengajuanPengujian = new PengajuanPengujian();
        $pengajuanPengujian = $pengajuanPengujian->store($request,'draft');

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

        $staf_teknis = new \App\Models\User();

        $staf_teknis = $staf_teknis->whereHas('roles', function($q){
            $q->where('name', 'staf_teknis');
        })->first();

        Notification::send($staf_teknis, new VerifikasiUserMail($pengajuan->masterPengajuanPengujian->first(),$staf_teknis));

        return dtcApiResponse(200, $_pengajuan);
    }

    public function terima($regId)
    {
        $pengajuan =  new PengajuanPengujian($regId);
        $_pengajuan = $pengajuan->verifikasi(6);
        \App\Repositories\ProsesPengajuan::make(6, $regId);

        $user = new \App\Models\User();

        $staf_teknis = $user->whereHas('roles', function($q){
            $q->where('name', 'staf_teknis');
        })->first();

        $keuangan = $user->whereHas('roles', function($q){
            $q->where('name', 'keuangan');
        })->first();

        Notification::send($staf_teknis, new PengajuanDiSetujuiNotification($pengajuan->masterPengajuanPengujian->first(),$staf_teknis));
        Notification::send($keuangan, new PengajuanDiSetujuiNotification($pengajuan->masterPengajuanPengujian->first(),$keuangan));

        return dtcApiResponse(200, $_pengajuan);
    }

    public function tolak($regId, Request $request)
    {
        // TOLAK PENGAJUAN
        $pengajuan =  new PengajuanPengujian($regId);
        $pengajuan->tolak($request->komentar);

        $stafTeknis = \App\Models\User::stafTeknis();

        foreach ($stafTeknis as $key => $value) {
            Notification::send($value, new PengajuanDiTolakNotification($pengajuan->masterPengajuanPengujian->first()));
        }

        return dtcApiResponse(200, $pengajuan);
    }

    public function uploadBuktiTransaksi($regId, Request $request)
    {
        $pengajuan = new PengajuanPengujian($regId);
        $_pengajuan = $pengajuan->uploadBuktiTransaksi($request);

        $pengajuan->verifikasi(8);
        \App\Repositories\ProsesPengajuan::make(8, $regId);

        $keuangan = new \App\Models\User();

        $keuangan = $keuangan->whereHas('roles', function($q){
            $q->where('name', 'keuangan');
        })->first();

        Notification::send($keuangan, new UploadBuktiTransaksiNotification($pengajuan->masterPengajuanPengujian->first(),$keuangan) );

        return dtcApiResponse(200, $_pengajuan, 'Terima kasih, bukti transaksi anda berhasil ter uopload');
    }

    public function getKodeEbilling($regId)
    {
        $pengajuan = new PengajuanPengujian($regId);

        return dtcApiResponse(200, $pengajuan->masterPengajuanPengujian->first()->e_billing);
    }
}
