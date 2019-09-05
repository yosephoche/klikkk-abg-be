<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polling extends Model
{
    protected $table = 'polling';
    protected $fillable = ['question'];

    public function result()
    {
        return $this->hasMany('App\Models\PollingResult', 'polling_id', 'id');
    }
}
