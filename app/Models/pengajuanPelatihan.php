<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengajuanPelatihan extends Model
{
    protected $fillable = ['nama_pemohon','alamat','email','instansi','telepon','user_id'];

    public function jenisPelatihan()
    {
        return $this->belongsToMany('App\Models\JenisPelatihan');
    }
}
