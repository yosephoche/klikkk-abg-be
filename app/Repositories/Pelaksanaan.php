<?php

namespace App\Repositories;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\PengajuanNotFoundException;

class Pelaksanaan
{

    public $pengajuanPengujian;
    public $prosesPengajuan;
    public $tahapPengajuan;

    public function __construct($regId = null)
    {
        $this->pengajuanPengujian = $this->pengauanPengujian($regId);
        $this->tahapPengajuan = $this->tahapPengajuan();
    }

    public function pengauanPengujian($regId = null)
    {
        $pengajuanPengujian = app()->make('App\Models\PengajuanPengujian');

        if ($regId) {
            $_pengajuanPengujian = $pengajuanPengujian->where('regId', $regId);
            return $_pengajuanPengujian->first()?$_pengajuanPengujian:$pengajuanPengujian;
        }

        return $pengajuanPengujian;
    }

    public function tahapPengajuan()
    {
        return app()->make('App\Models\TahapPengajuanPengujian');
    }

    public function pelaksanaan()
    {
        if ($this->pengajuanPengujian instanceof \Illuminate\Database\Eloquent\Builder) {
            // dd($this->pengajuanPengujian->first()->prosesPengajuan);
            $pengajuanPengujian = $this->pengajuanPengujian->first();
            $prosesPengajuan = $pengajuanPengujian->prosesPengajuan;
            $regId = $pengajuanPengujian->regId;

            $tahapPengajuan = $this->tahapPengajuan->pelaksanaan()->get()->map(function($value) use ($pengajuanPengujian, $prosesPengajuan, $regId) {


                $progres = $prosesPengajuan->where('tahap_pengajuan',$value->id);
                $progresSebelumnya = $prosesPengajuan->where('tahap_pengajuan',(int)$value->id - 1 );

                $prosesSelanjutnya = false;
                if (isset($progresSebelumnya->first()->tahap_pengajuan) && $progresSebelumnya->first()->tahap_pengajuan == 9 && isset($progres->first()->tanggal_mulai) == false) {
                    $prosesSelanjutnya = true;
                }
                else{
                    if ( ((int)$pengajuanPengujian->tahap_pengajuan + 1) === $value->id && isset($progresSebelumnya->first()->tanggal_mulai) && isset($progresSebelumnya->first()->tanggal_selesai)) {
                        $prosesSelanjutnya = true;
                    }
                }

                // dd($progresSebelumnya);

                $data['id'] = $value->id;
                $data['nama'] = $value->nama;
                $data['tahap'] = $value->id;

                $data['start_button'] = $this->startButton($progres,$regId, $value->id,$prosesSelanjutnya);

                $data['finish_button'] = $this->finishButton($progres, $regId);

                $data['start_date'] = isset($progres->first()->tanggal_mulai)?prettyDate($progres->first()->tanggal_mulai):'';
                $data['finish_date'] = isset($progres->first()->tanggal_selesai)?prettyDate($progres->first()->tanggal_selesai):'';

                return $data;
            });

            return $tahapPengajuan;
        }

        throw new PengajuanNotFoundException();
    }

    private function startButton($value, $regId,$tahap, $flagProsesSelanjutnya){
        $tipe = null;
        $action = null;
        if ($flagProsesSelanjutnya === false) {

            if (isset($value->first()->tanggal_mulai)) {
                if (isset($value->first()->tanggal_selesai)) {
                    $tipe = 'selesai';
                    $action = null;
                }else{
                    $tipe = 'progres';
                    $action = null;
                }

            }
            else{
                $tipe = 'mulai';
                $action = isset($value->first()->tahap_pengajuan)?route('api.admin.personel-k3.mulai',['regId'=>$regId,'tahap'=>$value->first()->tahap_pengajuan]):null;
            }
        }else{
            $tipe = 'mulai';
            $action = route('api.admin.personel-k3.mulai',['regId'=>$regId,'tahap'=>$tahap]);
        }

        return ['type' => $tipe, 'action' => $action];
    }

    private function finishButton($value, $regId){
        $tipe = null;
        $action = null;

        if (isset($value->first()->tanggal_selesai)) {
            $tipe = 'selesai';
            $action = null;
        }
        else{
            $tipe = 'mulai';
            $action = isset($value->first()->tahap_pengajuan)?route('api.admin.personel-k3.selesai',['regId' => $regId , 'tahap' => $value->first()->tahap_pengajuan]):null;
        }

        return ['type' => $tipe, 'action' => $action];
    }

    public function mulai($tahap)
    {
        if ($this->pengajuanPengujian instanceof \Illuminate\Database\Eloquent\Builder) {
            $pengajuanPengujian = $this->pengajuanPengujian->first();
            $pengajuanPengujian->tahap_pengajuan = $tahap;
            $pengajuanPengujian->save;
            \App\Repositories\ProsesPengajuan::make($tahap, $pengajuanPengujian->regId);
            return $pengajuanPengujian;
        }

        throw new PengajuanNotFoundException();
    }

    public function selesai($tahap)
    {
        if ($this->pengajuanPengujian instanceof \Illuminate\Database\Eloquent\Builder) {
            $pengajuanPengujian = $this->pengajuanPengujian->first();
            $prosesPengajuan = $pengajuanPengujian->prosesPengajuan;

            if ($prosesPengajuan = $prosesPengajuan->where('tahap_pengajuan',$tahap)->first()) {
                $prosesPengajuan->tanggal_selesai = \Carbon\Carbon::now();
                $prosesPengajuan->save();

                if ($tahap == 19) {
                    $pengajuanPengujian->status_pengajuan = 'selesai';
                    $pengajuanPengujian->save();
                }

                return $pengajuanPengujian;
            }else{
                throw new DataNotFoundException('Proses pengajuan tidak ditemukan');
            }
        }

        throw new PengajuanNotFoundException();
    }

}
