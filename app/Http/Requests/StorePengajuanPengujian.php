<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanPengujian extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_pemohon' => 'required|max:255',
            'nama_perusahaan' => 'required|max:255',
            'alamat' => 'required',
            'no_telepon' => 'required|max:20',
            'email' => 'required|email',
            'jenis_usaha' => 'max:255',
            'rencana_lokasi_pengujian' => 'max:255',
            'tujuan_pengujian' => 'max:255',
            'e_billing' => 'max:255',
        ];
    }
}
