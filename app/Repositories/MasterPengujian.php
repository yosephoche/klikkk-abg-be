<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Repositories\Traits\ApiResponseTrait;

class MasterPengujian
{
    use ApiResponseTrait;

    public $jenis_pengujian;
    public $parameter_pengujian;

    public function __construct( $id_jenis_pengujian = null )
    {
        $this->jenis_pengujian($id_jenis_pengujian);

        return $this;
    }

    public function jenis_pengujian($id_jenis_pengujian = null)
    {
        $jenis_pengujian = app()->make('App\Models\JenisPengujian');

        if ($id_jenis_pengujian) {

            $this->jenis_pengujian = $jenis_pengujian->where('id', $id_jenis_pengujian)->orWhere('uuid', $id_jenis_pengujian)->first();

            if ($this->jenis_pengujian->id) {
                $this->parameter_pengujian = $this->parameter_pengujian($this->jenis_pengujian->id);
            }
            else{
                $this->parameter_pengujian = $this->parameter_pengujian();
            }
        }else{
            $this->jenis_pengujian = $jenis_pengujian;
            $this->parameter_pengujian = $this->parameter_pengujian();
        }
    }

    public function parameter_pengujian($id_jenis_pengujian = null)
    {
        $parameter_pengujian = app()->make('App\Models\ParameterPengujian');

        if ($id_jenis_pengujian) {
            return $parameter_pengujian->where('id_jenis_pengujian', $id_jenis_pengujian)->get();
        }

        return $parameter_pengujian;


    }

    public function all()
    {
        $jenis_pengujian = $this->jenis_pengujian;

        $res = $jenis_pengujian->all()->map(function($value){
            $param = $this->parameter_pengujian($value->id);

            if ($param) {
                $paramameter = $param->map(function($value){
                    return [
                        'uuid' => $value->uuid,
                        'nama' => $value->nama,
                        'biaya' => $value->biaya
                    ];
                });
            }
            else{
                $paramameter=null;
            }

            return [
                'uuid' => $value->uuid,
                'nama' => $value->nama,
                'urutan' => $value->urutan,
                'parameter' => $paramameter
            ];
        });

        return $res;
    }

    public function storeJenisPengujian($data)
    {
        if (isset($this->jenis_pengujian->id)) {
            $jenis_pengujian = $this->jenis_pengujian;
        }
        else{
            $jenis_pengujian = $this->jenis_pengujian;
        }

        $jenis_pengujian->uuid = isset($this->jenis_pengujian->uuid)?$this->jenis_pengujian->uuid:Str::uuid();
        $jenis_pengujian->nama = $data->nama;
        $jenis_pengujian->urutan = $data->urutan;
        $jenis_pengujian->status = $data->status;

        return $this->apiResponse($this->jenis_pengujian->save());
    }

    public function storeParameter($data)
    {
        $jenis_pengujian = $this->jenis_pengujian->first();

        $data = ($data instanceof \Illuminate\Http\Request )?$data->toArray():$data;

        foreach ($data['nama'] as $key => $val) {
            $parameter_pengujian[$key] = $this->prepareParameter($data, $key);
        }

        return $this->apiResponse($jenis_pengujian->parameterPengujian()->saveMany($parameter_pengujian));
    }

    public function updateJenisPengujian($data)
    {
        return $this->storeJenisPengujian($data);
    }

    public function updateParameter($data)
    {
        try {
            /** get list of old parameter id from parameter_pengujian property */
            $oldParameterId = $this->parameter_pengujian->pluck('uuid')->toArray();
            /** get deleted parameter by comparing id from form request and old parameter */
            $deletedParameter = array_diff($oldParameterId,$data['uuid']);

            /** delete deleted parameter by id */
            \DB::table('parameter_pengujian')->whereIn('uuid', $deletedParameter)->delete();

            /** update old param or add new param */
            foreach ($data['nama'] as $key => $value) {
                if (isset($data['uuid'][$key])) {
                    $update[$key] = $this->prepareParameter($data,$key);

                    $update[$key]->save();
                }
                else{
                    $save[$key] = $this->prepareParameter($data,$key);

                    $jenis_pengujian = $this->jenis_pengujian->first();

                    $jenis_pengujian->parameterPengujian()->saveMany($save);
                }
            }

            return dtcApiResponse(200,true,responseMessage('update'));
        } catch (\Illuminate\Database\QueryException $th) {
            return dtcApiResponse(502,false,implode($th->errorInfo));
        }

    }

    private function prepareParameter($data, $index)
    {
        $identifier = isset($data['uuid'][$index])?$data['uuid'][$index]:null;

        if ($identifier) {
            $parameter_pengujian = $this->parameter_pengujian()->where('id', $identifier)->orWhere('uuid', $identifier)->first();
        }
        else{
            $parameter_pengujian = $this->parameter_pengujian();
        }

        $parameter_pengujian->uuid = isset($identifier)?$identifier:Str::uuid();
        $parameter_pengujian->nama = $data['nama'][$index];
        $parameter_pengujian->biaya = $data['biaya'][$index];
        $parameter_pengujian->status = $data['status'][$index];

        return $parameter_pengujian;
    }

    public function getJenisPengujian($id)
    {
        $this->jenis_pengujian = $this->jenis_pengujian->where('id', $id)->orWhere('uuid', $id)->first();

        return $this;
    }

    public function delete()
    {
        return $this->apiResponse($this->jenis_pengujian->delete(), 'delete');
    }
}
