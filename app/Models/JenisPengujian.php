<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengujian extends Model
{
    protected $table = 'jenis_pengujian';
    protected $fillable = ['uuid', 'nama', 'status', 'urutan'];

    public function parameterPengujian(){
        return $this->hasMany('\App\Models\ParameterPengujian', 'id_jenis_pengujian', 'id');
    }

    public function scopeActive($query){
        return $query->where('status', true);
    }

    public function peraturanParameter()
    {
        return $this->hasMany('App\Models\PeraturanParameter','id_jenis_pengujian','id');
    }

}
