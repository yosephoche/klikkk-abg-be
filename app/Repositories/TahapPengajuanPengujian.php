<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Repositories\Traits\ApiResponseTrait;

class TahapPengajuanPengujian
{
    // TODO :: implementasi dengan user dan hide user id
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
        $res = $tahap_pengajuan->all()->map(function($value, $key){
            return [
                'uuid' => $value->uuid,
                'nama' => $value->nama,
                'urutan' => $value->urutan,
                'pic' => $value->pic
            ];
        });

        return $res;
    }

    private function model(){
        return app()->make('App\Models\TahapPengajuanPengujian');
    }

    public function store($data){

        $tahap_pengajuan = $this->prepare($data);

        return $this->apiResponse($tahap_pengajuan->save());
    }

    public function update($data){
        $tahap_pengajuan = $this->prepare($data);

        return $this->apiResponse($tahap_pengajuan->save(),'update');
    }

    public function delete($id){
        return $this->apiResponse($this->tahap_pengajuan->where('uuid', $id)->first()->delete(), 'delete');
    }

    private function prepare($data){
        $tahap_pengajuan = $this->tahap_pengajuan;

        if ($data->id) {
            $tahap_pengajuan = $tahap_pengajuan->where('uuid', $data->id)->first();
        }

        $tahap_pengajuan->nama = $data->nama;
        $tahap_pengajuan->uuid = $data->uuid?$data->uuid:Str::uuid();
        $tahap_pengajuan->urutan = $data->urutan;
        $tahap_pengajuan->pic = $data->pic;

        return $tahap_pengajuan;
    }

}
