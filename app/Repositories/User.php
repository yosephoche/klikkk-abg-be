<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = "Password missmatch";
                return response($response, 422);
            }

        } else {
            $response = 'User does not exist';
            return response($response, 422);
        }
    }

    public function register($request){
        $request['password']=Hash::make($request['password']);
        $request['uuid'] = \Str::uuid();
        $user = $this->model::create($request->toArray());
        // TODO : send verivication mail to users email

        // $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        // $response = ['token' => $token];

        return response(['User anda berhasil terdaftar, silahkan konfirmasi email anda untuk menyelesaikan proses pendaftaran'], 200);
    }

    public static function logout($request){
        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    }

    public static function user($id = null){
        return app()->make('App\Models\User');
    }

    public function admin(){
        $this->model = $this->model->where('jenis_akun', 1);
        return $this;
    }

    public function roles(){
        return $this->model = $this->model->roles();
    }
}
