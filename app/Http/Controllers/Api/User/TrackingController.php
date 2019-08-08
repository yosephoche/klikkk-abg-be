<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrackingController extends Controller
{
    public function index($regId)
    {
        return  \App\Repositories\PengajuanPengujian::trackingPengajuan($regId);
    }
}
