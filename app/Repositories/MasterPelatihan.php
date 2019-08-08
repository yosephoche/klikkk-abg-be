<?php

namespace App\Repositories;

class MasterPelatihan
{
    protected $master_pelatihan;
    protected $model;
    protected $limit = 10;

    public function __Construct($id_jenis_pelatihan = null)
    {
        $this->model();

        if ($id_jenis_pelatihan) {
            $this->master_pelatihan = $this->getOne($id_jenis_pelatihan);
        }

        return $this;
    }

    public function getAll()
    {
        $master_pelatihan = $this->model;
        $master_pelatihan = $master_pelatihan->paginate($this->limit);

        return dtcApiResponse(200, $master_pelatihan);
    }

    public function getOne($uuid){
        return $this->model->where('uuid', $uuid)->orWhere('id', $uuid);
    }

    public function edit()
    {
        $master_pelatihan = $this->master_pelatihan;
        if ($master_pelatihan->first()) {
            $master_pelatihan = $master_pelatihan->first();

            return dtcApiResponse(200, $master_pelatihan);
        }else{
            return dtcApiResponse(404,null,'Pelatihan tidak ditemukan');
        }

    }

    public function model(){
        $this->model = app()->make('App\Models\JenisPelatihan');

        return $this;
    }

    public function save($data){

        if ($this->master_pelatihan) {
            if ($this->master_pelatihan->first()) {

                $master_pelatihan = $this->master_pelatihan->first();
                $master_pelatihan->parameter = $data->parameter;
                $master_pelatihan->durasi = $data->durasi;
                $master_pelatihan->biaya = $data->biaya;
                $master_pelatihan->status = $data->status;

                $master_pelatihan->save();

                return dtcApiResponse(200,$master_pelatihan,responseMessage('update'));

            }else{
                return dtcApiResponse(404, null, 'Data pelatihan tidak ditemukan');
            }
        }
        else{
            $master_pelatihan = $this->model;

            $master_pelatihan->uuid = \Str::uuid();
            $master_pelatihan->parameter = $data->parameter;
            $master_pelatihan->durasi = $data->durasi;
            $master_pelatihan->biaya = $data->biaya;
            $master_pelatihan->status = $data->status;

            if ($master_pelatihan -> save()) {
                return dtcApiResponse(200, $master_pelatihan, responseMessage());
            }

        }

    }

    public function delete(){
        $master_pelatihan = $this->master_pelatihan;

        if ($master_pelatihan->first()) {
            $master_pelatihan->delete();

            return dtcApiResponse(200,null,responseMessage('delete'));
        }else{
            return dtcApiResponse(404, null, 'Pelatihan tidak ditemukan');
        }
    }
}
