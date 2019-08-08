<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class pelatihanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        return [
            'id' => $this->id,
            'nama_pemohon' => $this->nama_pemohon,
            'alamat' => $this->alamat,
            'email' => $this->email,
            'instansi' => $this->instansi,
            'telepon' => $this->telepon,
            'jenisPelatihan' => $this->jenisPelatihan,
        ];
    }
}
