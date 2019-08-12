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
    public $peraturanParameter;

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

    public function peraturanParameter()
    {
        return app()->make('\App\Models\PeraturanParameter');
    }

    public function all()
    {
        $jenis_pengujian = $this->jenis_pengujian;

        return $jenis_pengujian->with(['parameterPengujian', 'peraturanParameter'])->orderBy('urutan')->get()->toArray();

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

    public function storePeraturan($data)
    {
        $jenis_pengujian = $this->jenis_pengujian;

        $data = ($data instanceof \Illuminate\Http\Request )?$data->toArray():$data;

        $peraturan = $this->peraturanParameter();
        $peraturan->peraturan = $data['peraturan'];

        $jenis_pengujian = $jenis_pengujian->where('uuid', $data['id_jenis_pengujian'])->first();

        try {
            return dtcApiResponse(200, $jenis_pengujian->peraturanParameter()->save($peraturan), responseMessage('save') );
        } catch (QueryException $th) {
            return databaseExceptionError(implode(', ',$th->errorInfo));
        }
    }

    public function updatePeraturan($data)
    {
        $peraturan = $this->peraturanParameter();
        $peraturan = $peraturan->where('id', $data->id_peraturan)->first();
        $peraturan->peraturan = $data->peraturan;
        $peraturan->save();

        return dtcApiResponse(200, $peraturan);
    }

    public function deletePeraturan($data)
    {
        $peraturan = $this->peraturanParameter();
        $peraturan = $peraturan->where('id', $data->id_peraturan)->first();
        $peraturan->delete();

        return dtcApiResponse(200, null,'Data berhasil di hapus');
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

    public function editPeraturan($id)
    {
        $peraturanParameter = $this->peraturanParameter();
        $peraturanParameter = $peraturanParameter->where('id', $id)->first();
        return dtcApiResponse(200, $peraturanParameter);
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

    public function getParameter($uuid)
    {
        return dtcApiResponse(200, ParameterPengujian::where('uuid', $uuid)->first());

    }
}
