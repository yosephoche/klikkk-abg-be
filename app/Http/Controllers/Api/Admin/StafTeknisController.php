<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\QnA;
use App\Models\Answer;
use App\Repositories\Traits\forumTrait;
use App\Http\Resources\QnAResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PengajuanPengujian;
use App\Models\pengajuanPelatihan;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifikasiStafTeknisNotification;
use App\Http\Resources\pelatihanResource;

class StafTeknisController extends Controller
{
    use forumTrait;

    public function index(Request $request)
    {
        $pengajuanPengujian = new PengajuanPengujian();

        if($request->filter == 'pelatihan'){
            $pengajuanPelatihan = pengajuanPelatihan::orderBy('id','desc')->paginate(10);
            $data = $pengajuanPelatihan;
        } else {
            $daftarPengajuan = $pengajuanPengujian->getListPengajuan($request, $request->filter);
            $data = $daftarPengajuan;
        }
        return dtcApiResponse(200, $data);
    }

    public function indexQnA()
    {
        $data = QnA::orderBy('id','desc')->paginate(10);
        $response = QnAResource::collection($data);
        return $this->collectionHttpResponse($response,$data);
    }

    public function showQnA($id)
    {
        $data = QnA::find($id);
        if(isset($data))
        {
            $response = new QnAResource($data);
            return $this->singleHttpResponse($data,$response);
        } else {
            return $this->notFound();
        }
    }


    public function showPelatihan($id)
    {
        $data = pengajuanPelatihan::find($id);

        if(isset($data))
        {
            $response = new pelatihanResource($data);
            return dtcApiResponse(200, $response);
        } else {
            return dtcApiResponse(404,'Not Found','Pengajuan Pelatihan TIdak Di temukan');
        }
    }

    public function riwayat(Request $request)
    {
        // $pengajuanPengujian = new PengajuanPengujian();
        // $daftarPengajuan = $pengajuanPengujian->getListPengajuan($request, $request->filter);

        return dtcApiResponse(200, PengajuanPengujian::riwayat(3, $request));
    }

    public function show($regId)
    {
        $pengajuan =  PengajuanPengujian::getOne($regId);

        return dtcApiResponse(200, $pengajuan);
    }

    public function getMasterData()
    {
        $masterPengujian = new \App\Repositories\MasterPengujian();

        return dtcApiResponse(200, $masterPengujian->all());
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

    public function storeBiayaTambahan($regId, Request $request)
    {
        $pengajuan = new PengajuanPengujian($regId);
        $biayaTambahan = $pengajuan->storeBiayaTambahan($request);
        return dtcApiResponse(200,$biayaTambahan);
    }

    public function verifikasiPengajuan($regId)
    {
        $pengajuan =  new PengajuanPengujian($regId);
        $_pengajuan = $pengajuan->verifikasi(4);
        \App\Repositories\ProsesPengajuan::make(4, $regId);
        Notification::send($pengajuan->masterPengajuanPengujian->first()->users, new VerifikasiStafTeknisNotification($pengajuan->masterPengajuanPengujian->first()));

        return dtcApiResponse(200, $_pengajuan);
    }

    public function uploadKup($regId, Request $request)
    {
        $pengajuan = new PengajuanPengujian($regId);

        return dtcApiResponse(200, $pengajuan->uploadKup($request), 'Berkas KUP berhasil di upload');
    }

    public function uploadProposal($regId, Request $request)
    {
        $pengajuan = new PengajuanPengujian($regId);

        return dtcApiResponse(200, $pengajuan->uploadProposal($request), 'Berkas Proposal berhasil di upload');
    }

    public function uploadSuratPengantar($regId, Request $request)
    {
        $pengajuan = new PengajuanPengujian($regId);

        return dtcApiResponse(200, $pengajuan->uploadSuratPEngantar($request), 'Berkas Surat Pengantar  berhasil di upload');
    }

    public function cetak($regId)
    {
        $pengajuan = new PengajuanPengujian($regId);
        return dtcApiResponse(200,$pengajuan->cetak());
    }



}
