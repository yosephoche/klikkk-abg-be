<?php

namespace App\Repositories;

use App\Repositories\PengajuanPengujian;
use Zend\Diactoros\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifikasiKepalaBalai;

class KepalaBalai
{
    protected $pengajuanPengujian;

    public function __construct()
    {
        $this->pengajuanPengujian = $this->pengajuanPengujian();
    }

    private function pengajuanPengujian($idPengajuan = null){
        if ($idPengajuan) {
            return new PengajuanPengujian($idPengajuan);
        }
        return new PengajuanPengujian();
    }

    public function listPengajuan($request)
    {
        return dtcApiResponse(200,$this->pengajuanPengujian->getListPengajuan($request, 1));
    }

    public static function showPengajuan($regId)
    {
        // tambah proses & update tahap pengajuan & update tanggal selesesai pada proses sebelumnya
        $pengajuan =  PengajuanPengujian::getOne($regId);
        // dd($pengajuan);
        return dtcApiResponse(200, $pengajuan);

    }

    public static function verifikasi($regId)
    {
        $pengajuan =  new PengajuanPengujian($regId);
        $_pengajuan = $pengajuan->verifikasi(3);
        \App\Repositories\ProsesPengajuan::make(3, $regId);

        Notification::send($pengajuan->masterPengajuanPengujian->first()->users, new VerifikasiKepalaBalai($pengajuan->masterPengajuanPengujian->first()));

        return dtcApiResponse(200, $_pengajuan);

    }

    public static function disposisi($regId)
    {
        $pengajuan =  new PengajuanPengujian($regId);
        $_pengajuan = $pengajuan->verifikasi(2);
        \App\Repositories\ProsesPengajuan::make(2, $regId);

        return dtcApiResponse(200, $_pengajuan);
    }

    public function disposisiAll($request)
    {
        $listPengajuan = $this->pengajuanPengujian->getListPengajuan($request,1);
        foreach ($listPengajuan as $key => $value) {

            $pengajuaPengujian = new PengajuanPengujian($value['nomor_pengajuan']);
            $pengajuaPengujian->verifikasi(2);

            \App\Repositories\ProsesPengajuan::make(2, $value['nomor_pengajuan']);
        }

        return dtcApiResponse(200, null, count($listPengajuan).' Pengajuan Telah berhasil di disposisikan');
    }

    public static function riwayat($request)
    {
        return dtcApiResponse(200, PengajuanPengujian::riwayat(1, $request));
    }
}
