<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\KepalaBalai;

class KepalaBalaiController extends Controller
{
    public function index(Request $request)
    {
        $kepalaBalai = new KepalaBalai();

        return $kepalaBalai->listPengajuan($request);
    }

    public function show($regId){
        return KepalaBalai::showPengajuan($regId);
    }

    public function verifikasi($regId)
    {
        return KepalaBalai::verifikasi($regId);
    }

    public function disposisi($regId)
    {
        return KepalaBalai::disposisi($regId);
    }

    public function disposisiAll(Request $request)
    {
        $kepalaBalai = new KepalaBalai();
        return $kepalaBalai->disposisiAll($request);

    }
}
