<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class User extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
        return $this;
    }

    public function model(){
        return 'App\Models\User';
    }

    public function login($request){
        $user = $this->model::where('email', $request->email)->first();

        if ($user) {
            if ($user->hasVerifiedEmail()) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $jenis_akun = \DB::table('jenis_akun')->where('id',$user->jenis_akun);
                    $jenis_akun = $jenis_akun->first()?$jenis_akun->first()->nama:null;
                    $response = [
                        'token' => $token,
                        'user_id' => $user->user_id,
                        'nama_lengkap' => $user->nama_lengkap,
                        'pekerjaan' => $user->pekerjaan,
                        'instansi' => $user->instansi,
                        'jenis_akun' => $jenis_akun,
                        'avatar' => $user->avatar?asset('user/avatar'.$user->avatar):null,
                        'role' => $user->roles()->get()->map(function($value){ return $value->name; })
                    ];
                    return dtcApiResponse(200, $response);
                } else {
                    $response = "Password missmatch";
                    return dtcApiResponse(422,null,$response);
                }
            } else{
                $response = 'Email not verified';
                return dtcApiResponse(401,null,$response);
            }

        } else {
            $response = 'User does not exist';
            return dtcApiResponse(404,null,$response);
        }
    }

    public function register($request){
        $request['password']=Hash::make($request['password']);
        $request['uuid'] = \Str::uuid();
        $user = $this->model::create($request->toArray());
        $roles = Role::where('name', 'user')->first()->id;

        $user->roles()->attach($roles);

        // TODO : send verivication mail to users email

        // $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        // $response = ['token' => $token];
        return dtcApiResponse(200, null, 'User anda berhasil terdaftar, silahkan konfirmasi email anda untuk menyelesaikan proses pendaftaran');
        // return response([], 200);
    }

    public static function logout($request){
        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    }

    // public static function userModel($id = null){
    //     return app()->make('App\Models\User');
    // }

    public static function user($user){
        return (new self)->model->where('id', $user)->OrWhere('uuid', $user)->first();
    }

    public function admin(){
        $this->model = $this->model->where('jenis_akun', 1);
        return $this;
    }

    public function roles(){
        return $this->model = $this->model->roles();
    }

    public static function getRegisterData(){
        // ->pluck('nama','id')->toArray()
        $jenis_akun = \DB::table('jenis_akun')->get()->map(function($value){
            if ($value->nama != 'BBPK3') {
                return [
                    'id' => $value->id,
                    'name' => $value->nama
                ];
            }

        })->filter(function($value){
            return !empty($value);
        });

        $data['jenis_akun'] = $jenis_akun->toArray();

        return
            dtcApiResponse(200,$data);
    }
}
