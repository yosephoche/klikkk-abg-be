<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaTambahan extends Model
{
    protected $table = 'biaya_tambahan';
    protected $fillable = ['id_pengajuan', 'nama_biaya','biaya', 'jumlah' , 'jumlah_orang'];
    public $timestamps = false;

    public function pengajuanPengujian()
    {
        return $this->belongsTo('App\Models\PengajuanPengujian','id_pengajuan','id');
    }


}
