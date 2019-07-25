<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $table = 'email_verification';
    protected $fillable = ['user_id', 'token'];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
