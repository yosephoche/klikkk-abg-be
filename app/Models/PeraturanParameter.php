<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeraturanParameter extends Model
{
    protected $table ='peraturan_parameter';
    protected $fillable = ['id_jenis_pengujian', 'peraturan'];
    public $timestamps = false;
}
