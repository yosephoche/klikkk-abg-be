<?php

namespace App\Repositories;

use App\Repositories\PengajuanPengujian;

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
        \App\Repositories\ProsesPengajuan::make(2, $regId);
        // dd($pengajuan);
        return dtcApiResponse(200, $pengajuan);

    }
}
