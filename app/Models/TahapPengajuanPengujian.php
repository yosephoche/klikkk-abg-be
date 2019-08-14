<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahapPengajuanPengujian extends Model
{
    protected $table = 'tahap_pengajuan_pengujian';
    protected $fillable = ['uuid', 'nama', 'urutan', 'pic'];

    public function user(){
        return $this->belongsTo('App\Models\User','pic','id');
    }

    public function scopePelaksanaan($query)
    {
        return $query->whereIn('id', [10,11,12,13,14,15,16,17,18,19,20])->orderBy('urutan');
    }
}
