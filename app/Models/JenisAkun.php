<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisAkun extends Model
{
    use SoftDeletes;
    protected $table = 'jenis_akun';
    protected $fillable = ['uuid', 'nama'];

    public function save(array $options = [])
    {

        if (!$this->uuid ) {
            $this->uuid = \Str::uuid();
        }

        parent::save();
    }

}
