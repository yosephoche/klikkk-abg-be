<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Repositories\Traits\ApiResponseTrait;
use Illuminate\Database\QueryException;

class TahapPengajuanPengujian
{
    use ApiResponseTrait;

    protected $tahap_pengajuan ;

    public function __construct($id = null)
    {
        $this->tahap_pengajuan = $this->model();

        return $this;
    }

    public function all()
    {
        $tahap_pengajuan = $this->tahap_pengajuan;
        $tahap_pengajuan = $tahap_pengajuan->all()->map(function($value){
            return [
                'uuid' => $value->uuid,
                'nama' => $value->nama,
                'urutan' => $value->urutan,
                'pic' => $value->user->nama_lengkap
            ];
        });

        $user = \App\Models\User::where('jenis_akun', 1)->get()->map(function($value) {
            if ($value->roles()->first()) {
                return [
                    'id' => $value->id,
                    'uuid' => $value->uuid,
                    'nama' => $value->nama_lengkap,
                    'role' => $value->roles()->first()->name
                ];
            }
        })->filter()->values();

        return dtcApiResponse(200,compact('tahap_pengajuan','user'));
    }

    private function model(){
        return app()->make('App\Models\TahapPengajuanPengujian');
    }

    public function store($data){

        $tahap_pengajuan = $this->prepare($data);
        try {

            return dtcApiResponse(200,$tahap_pengajuan->save());
        } catch (QueryException $th) {
            return databaseExceptionError(implode(', ', $th->errorInfo));
        }
    }

    public function update($data){
        $tahap_pengajuan = $this->prepare($data);
        try {
            return dtcApiResponse(200,$tahap_pengajuan->save(),'update');
        } catch (QueryException $th) {
            return databaseExceptionError(implode(', ', $th->errorInfo));
        }

    }

    public function delete($id){
        try {
            return dtcApiResponse(200,$this->tahap_pengajuan->where('uuid', $id)->first()->delete(), 'delete');
        } catch (QueryException $th) {
            return databaseExceptionError(implode(', ', $th->errorInfo));
        }
    }

    private function prepare($data){
        $tahap_pengajuan = $this->tahap_pengajuan;

        if ($data->id) {
            $tahap_pengajuan = $tahap_pengajuan->where('uuid', $data->id)->first();
        }

        $pic = (int) $data->pic ? $data->pic: \App\Models\User::where('uuid', $data->pic)->first()->id;

        // $tahap_pengajuan->nama = $data->nama;
        // $tahap_pengajuan->uuid = $data->uuid?$data->uuid:Str::uuid();
        // $tahap_pengajuan->urutan = $data->urutan;
        $tahap_pengajuan->pic = $pic;

        return $tahap_pengajuan;
    }

    public static function getTahapUrutan($urutan = 1){
        return (new self)->model()->where('urutan', $urutan)->first()->id;
    }

}
