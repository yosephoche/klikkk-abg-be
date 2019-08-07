<?php

namespace App\Repositories;

use App\Models\PengajuanPengujian;
use App\Exceptions\PengajuanNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ProsesPengajuan extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function model(){
        return 'App\Models\ProsesPengajuan';
    }

    public static function make($tahap, $pengajuan){

        $proses_pengajuan = new self();
        $proses_pengajuan = $proses_pengajuan->model;


        $_pengajuan = static::getPengajuan($pengajuan);

        if ($_pengajuan instanceof Builder) {
            $_pengajuan  = $_pengajuan->first();

            // cek proses sudah ada
            if ($proses_pengajuan->cekSudahAda($_pengajuan->id, $tahap)->first() ==  null) {
                $proses_pengajuan->id_pengajuan = $_pengajuan->id;

                $proses_pengajuan->tanggal_mulai = Carbon::now();
                $proses_pengajuan->tahap_pengajuan = $tahap;
                $proses_pengajuan->uuid = \Str::uuid();

                $proses_pengajuan->save();
            }


            $_proses_pengajuan = $_pengajuan->prosesPengajuan->sortByDesc('tanggal_mulai')->first();
            $_proses_pengajuan->tanggal_selesai = Carbon::now();

            $_pengajuan->tahap_pengajuan = $tahap;
            $_pengajuan->save();


        }
        else{
            throw new PengajuanNotFoundException('proses');
        }
    }

    public static function getPengajuan($regId){
        $pengajuan = PengajuanPengujian::where('regId', $regId);
        // dd($pengajuan);
        return $pengajuan;

    }

}
