<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPengujian extends Model
{
    protected $table = 'pengajuan_pengujian';
    protected $fillable = [
                        'id',
                        'uuid',
                        'regId',
                        'nama_pemohon',
                        'nama_perusahaan',
                        'alamat',
                        'no_telepon',
                        'email',
                        'jenis_usaha',
                        'rencana_lokasi_pengujian',
                        'tujuan_pengujian',
                        'e_billing',
                        'status_pengajuan',
                        'tahap_pengujian',
                        'keterangan',
                        'total_biaya',
    ];

    public function tahapPengajuan()
    {
        return $this->hasOne('\App\Models\TahapPengajuanPengujian','tahap_pengujian', 'id');
    }

    public function detailPengajuanPengujian()
    {
        return $this->hasMany('\App\Models\DetailPengajuanPengujian', 'id_pengajuan_pengujian', 'id');
    }

    public function prosesPengajuan()
    {
        return $this->hasMany('\App\Models\ProsesPengajuan', 'id_pengajuan', 'id');
    }

    public function generateRegId()
    {
        return time();
    }

    public function scopeActive($query)
    {
        return $query->where('status_pengajuan', '=','aktif');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user', 'id');
    }

    public function save(array $options = [])
    {

        if (!$this->user && auth('api')->user()) {
            $this->user = auth('api')->user()->getKey();
        }

        parent::save();
    }
}
