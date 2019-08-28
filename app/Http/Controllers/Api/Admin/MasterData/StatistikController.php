<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatistikController extends Controller
{
    public function index($year)
    {
        return dtcApiResponse(200,\App\Repositories\PengajuanPengujian::statistik($year));
    }
}
