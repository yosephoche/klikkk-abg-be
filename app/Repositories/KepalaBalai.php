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
        return dtcApiResponse(200,$this->pengajuanPengujian->getListPengajuan($request));
    }

    public static function showPengajuan($regId)
    {
        // TODO::
        /**
        * update status pengajuan
        * update tanggal selesesai pada proses sebelumnya
        * tambah proses
        */
        return PengajuanPengujian::getOne($regId);
    }
}
