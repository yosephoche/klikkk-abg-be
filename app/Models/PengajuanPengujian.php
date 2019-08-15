<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\PengajuanNotFoundException;

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

    public function scopeTahap($query, $tahap)
    {
        if ((int)$tahap > 0) {
            if ($tahap == 1) {
                $tahap = auth('api')->user()->roles->first()->name == 'pengganti_kepala_balai'?2:1;
            }
            return $query->where('tahap_pengajuan', '=', $tahap);
        }
        else{
            if ($tahap == 'pengujian') {
                return $query->where('tahap_pengajuan', '=', 3);
            }

            if ($tahap == 'pembayaran') {
                return $query->whereIn('tahap_pengajuan', [6,7]);
            }

            if ($tahap == 'pelaksanaan') {
                return $query->where('tahap_pengajuan', '>=', 10);
            }

            throw new PengajuanNotFoundException();

        }
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user', 'id');
    }

    public function biayaTambahan()
    {
        return $this->hasMany('App\Models\BiayaTambahan', 'id_pengajuan', 'id');
    }

    public function save(array $options = [])
    {

        if (!$this->user && auth('api')->user()) {
            $this->user = auth('api')->user()->getKey();
        }

        parent::save();
    }

    public function scopeHistory($query)
    {
        $userId = auth('api')->user()->id;
        return $query->where('user', $userId);
    }
}
