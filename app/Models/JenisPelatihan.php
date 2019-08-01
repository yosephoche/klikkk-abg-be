<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelatihan extends Model
{
    protected $table = 'jenis_pelatihan';
    protected $fillable = ['uuid','parameter','durasi','biaya', 'status'];
}
