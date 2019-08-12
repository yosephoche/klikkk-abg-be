<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiwayatController extends Controller
{
    public function index()
    {
        $pengajuan = new \App\Repositories\PengajuanPengujian();
        return dtcApiResponse(200, $pengajuan->historyUser());
    }
}
