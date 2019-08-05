<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengajuanPengujian extends Model
{
    protected $table = 'detail_pengajuan_pengujian';
    protected $fillable = ['id_pengajuan_pengujian', 'id_parameter_pengujian', 'jumlah_titik'];
    public $timestamps = false;

    public function pengajuanPengujian()
    {
        return $this->belongsTo('\App\Models\PengajuanPengujian', 'id_pengajuan_pengujian');
    }

    public function parameterPengujian()
    {
        return $this->belongsTo('App\Models\ParameterPengujian', 'id_parameter_pengujian', 'id');
    }


}
