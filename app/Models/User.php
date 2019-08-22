<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'nama_lengkap', 'user_id', 'email', 'password', 'pekerjaan', 'instansi', 'no_telepon', 'jenis_akun', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function emailVerification()
    {
        return $this->hasMany('App\Models\EmailVerification', 'user_id', 'id');
    }

    public function pelatihan()
    {
        return $this->hasMany('App\Models\Pelatihan');
    }

    public function scopeIsAdmin($query)
    {
        return $query->where('jenis_akun', 1);
    }

    public static function stafTeknis()
    {
        return (new self)->whereHas('roles' , function($q){ $q->where('name', 'staf_teknis'); })->get();
    }

    public function survey()
    {
        return $this->belongsToMany('App\Models\SurveyQuestion','survey_results','user_id','question_id')->withTimestamps()->withPivot('answer');
    }

}
