<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUser extends FormRequest
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
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|string|confirmed|max:255',
            // 'pekerjaan' => 'required',
            'instansi' => 'string|max:255',
            'nip' => 'max:255',
            'no_telepon' => 'required|max:20',
            'jenis_akun' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama_lengkap.required' => 'Nama harus di isi',
            'nama_lengkap.max' => 'Nama tidak boleh melebihi 255 karakter',
            'email.required' => 'Email harus di isi',
            'email.unique' => 'Email yang di masukkan sudah terdaftar',
            'password.required' => 'Password harus di isi',
            'password.confirmed' => 'Password tidak sama dengan konfirmasi password',
            'pekerjaan.required' => 'Pekerjaan harus di isi',
            'no_telepon.required' => 'Nomor telepon harus di isi',
            'jenis_akun.required' => 'Jesni akun harus di isi'
        ];
    }

    // public function failedValidation()
    // {
    //     return dtcApiResponse(422,false,$this->errorBag);
    // }

    /**
     * Failed validation disable redirect
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(dtcApiResponse(422,false,array_values($validator->messages()->toArray() )));
    }
}
