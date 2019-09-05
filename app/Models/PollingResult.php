<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollingResult extends Model
{
    protected $table = 'polling_result';
    protected $fillable = ['polling_id', 'user_id','answer'];

    public function polling()
    {
        return $this->belongsTo('App\Models\Polling', 'polling_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
