<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use App\Models\EmailVerification;
use function GuzzleHttp\json_encode;

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

        $http = new \GuzzleHttp\Client;

        if ($user) {
            if ($user->hasVerifiedEmail()) {
                if (Hash::check($request->password, $user->password)) {

                    $response = $http->post(url('oauth/token'), [
                        'form_params' => [
                            'grant_type' => 'password',
                            'client_id' => env('PASSPORT_CLIENT_ID'),
                            'client_secret' => env('PASSPORT_SECRET_KEY'),
                            'username' => $request->email,
                            'password' => $request->password,
                            'scope' => '',
                        ],
                    ]);

                    $jenis_akun = \DB::table('jenis_akun')->where('id',$user->jenis_akun);
                    $jenis_akun = $jenis_akun->first()?$jenis_akun->first()->nama:null;

                    $response = [
                        'access_token' => json_decode((string) $response->getBody()),
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

        $email_verification = new EmailVerification();
        $email_verification['token'] = sha1(time());

        $user->emailVerification()->save($email_verification);

        Mail::to($user)->send(new VerifyEmail($user));

        return dtcApiResponse(200, null, 'User anda berhasil terdaftar, silahkan konfirmasi email anda untuk menyelesaikan proses pendaftaran');
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

        $data['jenis_akun'] = array_values($jenis_akun->toArray());

        return
            dtcApiResponse(200,$data);
    }

    public static function verifyUsersEmail($token){
        $m_token = \App\Models\EmailVerification::where('token', $token)->orderBy('created_at')->first();
        $user = (new self())->model->whereHas('emailVerification', function($q) use($token) { $q->where('token', $token); } )->first();

        if ($user) {
            $user->email_verified_at = \Carbon\Carbon::now();
            $user->save();
            $data['redirect'] = '/login';
            return dtcApiResponse(200,$data);
        }

        return dtcApiResponse(404,null, 'User tidak ditemukan');

    }
}
