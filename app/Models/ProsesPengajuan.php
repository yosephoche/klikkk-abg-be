<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsesPengajuan extends Model
{
    protected $table = 'proses_pengajuan';
    protected $fillable = ['uuid', 'jenis_pengajuan', 'id_pengajuan', 'tahap_pengajuan', 'pic', 'tanggal_mulai', 'tanggal_selesai'];
    protected $dates = [
        'tanggal_mulai', 'tanggal_selesai'
    ];

    public $timestamps = false;


    public function personInCharge()
    {
        return $this->belongsTo('App\Models\User', 'pic', 'id');
    }

    public function tahapPengajuan(){
        return $this->belongsTo('App\Models\TahapPengajuanPengujian', 'tahap_pengajuan', 'id');
    }

    public function pengajuanPengujian()
    {
        return $this->belongsTo('App\Models\PengajuanPengujian','id_pengajuan', 'id');
    }

    public function scopeCekSudahAda($query, $id, $tahap)
    {
        return $query->where('id_pengajuan', '=', $id)->where('tahap_pengajuan', '=', $tahap);
    }

}
