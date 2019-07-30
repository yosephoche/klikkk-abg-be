<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Repositories\Traits\ApiResponseTrait;
use Illuminate\Database\QueryException;
use App\Models\ParameterPengujian;

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
                        'biaya' => $value->biaya,
                        'status' => $value->status
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

        try {
            return dtcApiResponse(200, $jenis_pengujian->save(), responseMessage('save','success'));
        } catch (QueryException $th) {
            return databaseExceptionError(implode(', ',$th->errorInfo));
        }
    }

    public function storeParameter($data)
    {
        $jenis_pengujian = $this->jenis_pengujian;

        $data = ($data instanceof \Illuminate\Http\Request )?$data->toArray():$data;

        foreach ($data['nama'] as $key => $val) {
            $parameter_pengujian[$key] = $this->prepareParameter($data, $key);
        }

        try {
            return dtcApiResponse(200, $jenis_pengujian->parameterPengujian()->saveMany($parameter_pengujian), responseMessage('save') );
        } catch (QueryException $th) {
            return databaseExceptionError(implode(', ',$th->errorInfo));
        }
    }

    public function updateJenisPengujian($data)
    {
        return $this->storeJenisPengujian($data);
    }

    public function updateParameter($uuid, $data)
    {
        try {
            $parameter = ParameterPengujian::where('uuid', $uuid)->first();
            $parameter->nama = $data->nama;
            $parameter->biaya = $data->biaya;
            $parameter->status = $data->status;

            $parameter->save();

            return dtcApiResponse(200, $parameter, responseMessage());

        } catch (QueryException $th) {
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

    public function deleteParameter($uuid){
        try {
            ParameterPengujian::where('uuid', $uuid)->first()->delete();

            return dtcApiResponse(200, null, responseMessage('delete'));
        } catch (QueryException $th) {
            return dtcApiResponse(502, null,implode($th->errorInfo));
        }
    }

    public function saveParameter($id_jenis_pengujian, $data){
        try {
            $jenis_pengujian = $this->jenis_pengujian->where('uuid', $id_jenis_pengujian)->first();

            $parameter_pengujian = new ParameterPengujian();

            $parameter_pengujian->uuid = Str::uuid();
            $parameter_pengujian->nama = $data->nama;
            $parameter_pengujian->biaya = $data->biaya;
            $parameter_pengujian->status = $data->status;

            $jenis_pengujian->parameterPengujian()->save($parameter_pengujian);

            return dtcApiResponse(200, $parameter_pengujian, responseMessage('save'));

        } catch (QueryException $th) {
            return dtcApiResponse(502, null,implode($th->errorInfo));
        }
    }

    public function delete()
    {
        try {
            return dtcApiResponse(200,$this->jenis_pengujian->delete(),responseMessage('delete'));
        } catch (QueryException $th) {
            return dtcApiResponse(502,false,implode($th->errorInfo));
        }
        // return $this->apiResponse($this->jenis_pengujian->delete(), 'delete');
    }
}
