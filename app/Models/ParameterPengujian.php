<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterPengujian extends Model
{
    protected $table = 'parameter_pengujian';
    protected $fillable = ['uuid', 'id_jenis_pengujian', 'nama', 'biaya', 'status'];

    public function jenisPengujian(){
        return $this->belongsTo('\App\Models\JenisPengujian','id_jenis_pengujian','id');
    }

    public function scopeActive($query){
        return $query->where('status', true);
    }
}
