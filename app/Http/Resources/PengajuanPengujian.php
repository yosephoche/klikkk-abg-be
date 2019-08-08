<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PengajuanPengujian extends JsonResource
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
            'nama_pemohon' => $this->nama_pemohon,
            'alamat' => $this->alamat,
            'email' => $this->email,
            'lokasi_pengujian' => $this->rencana_lokasi_pengujian,
            'nama_perusahaan' => $this->nama_perusahaan,
            'nomor_telepon' => $this->nomor_telepon,
            'jenis_usaha' => $this->jenis_usaha,
            'tujuan' => $this->tujuan_pengujian
        ];
    }
}
