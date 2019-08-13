<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Notifications\VerifyEmail;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Traits\UploadTrait;

class User extends BaseRepository
{

    use UploadTrait;

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

                    $token = $user->createToken('User personal access token')->accessToken;

                    $jenis_akun = \DB::table('jenis_akun')->where('id',$user->jenis_akun);
                    $jenis_akun = $jenis_akun->first()?$jenis_akun->first()->nama:null;

                    $response = [
                        'user_id' => $user->user_id,
                        'token' => $token,
                        'email' => $user->email,
                        'nama_lengkap' => $user->nama_lengkap,
                        'pekerjaan' => $user->pekerjaan,
                        'instansi' => $user->instansi,
                        'jenis_akun' => $jenis_akun,
                        'avatar' => $user->avatar?asset('storage/'.$user->avatar):null,
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

        $email_verification = new EmailVerification();
        $email_verification['token'] = sha1(time());

        $user->emailVerification()->save($email_verification);

        // $user->notify(new VerifyEmail($user));
        Notification::send($user, new VerifyEmail($user));

        // Mail::to($user)->send(new AppVerifyEmail($user));
        // Mail::to('muh.zulkifli@docotel.com')->send(new AppVerifyEmail('muh.zulkifli@docotel.com'));

        return dtcApiResponse(200, null, 'User anda berhasil terdaftar, silahkan konfirmasi email anda untuk menyelesaikan proses pendaftaran');
    }

    public static function logout($request){
        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    }

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
        $user = (new self())->model->whereHas('emailVerification', function($q) use($token) { $q->where('token', $token); } );

        if ($user->first()) {
            $user = $user->first();
            $user->email_verified_at = \Carbon\Carbon::now();
            $user->save();
            \DB::table('email_verification')->where('token', $token)->delete();

            return $user;
        }

        return false;

    }

    public function getAllAdmin()
    {
        $user = $this->model->where('jenis_akun',1)->with('roles')->get();
        $user = $user->map(function($value){
            return [
                'id' => $value->id,
                'uuid' => $value->uuid,
                'user_id' => $value->user_id,
                'nama_lengkap' => $value->nama_lengkap,
                'email' => $value->email,
                'nip' => $value->nip,
                'no_telepon' => $value->no_telepon,
                'avatar' => $value->avatar?asset('storage/'.$value->avatar):null,
                'roles' => $value->roles->map(function($value){
                    return [
                        'id' => $value->id,
                        'name' => $value->name,
                        'display_name' => $value->display_name,
                        'description' => $value->description
                    ];
                })
            ];
        });

        return dtcApiResponse(200, $user);
    }

    public function registerAdmin($data){
        $user = $this->model;

        $user->uuid = \Str::uuid();
        $user->email = $data->email;
        $user->password = Hash::make($data->password);
        $user->nama_lengkap = $data->nama_lengkap;
        $user->pekerjaan = $data->pekerjaan;
        $user->no_telepon = $data->no_telepon;
        $user->email_verified_at = Carbon::now();
        $user->jenis_akun = 1;
        $user->nip = $data->nip;
        $user->instansi = 'BALAI PELATIHAN K3';

        try {
            if ($data->has('avatar')) {
                $image = $data->file('avatar');
                $name = str_slug($data->input('nama_lengkap')).'_'.time();
                $folder = '/uploads/avatar/';
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                $this->uploadOne($image, $folder, 'public', $name);
                $user->avatar = $filePath;
            }
        } catch (\Exception $e) {
            return dtcApiResponse(500,false, $e->getMessage());
        }

        try {
            $user->save();
            $user->avatar = userAvatar($user->avatar);
            return dtcApiResponse(200,$user,responseMessage());
        } catch (QueryException $th) {
            return databaseExceptionError(implode(', ',$th->errorInfo));
        }
    }

    public function getAdmin($uuid){
        $user = $this->model->where('uuid', $uuid);

        if ( $user->first() ) {
            $user = $user->first();
            $user->avatar = userAvatar($user->avatar);
            return dtcApiResponse(200,$user);
        }
        else{
            return dtcApiResponse(200, false,'User tidak ditemukan');
        }

    }

    public function updateAdmin($data)
    {
        $user = $this->model->where('uuid', $data->uuid);

        if ($user->first()) {
            $user = $user->first();
            $user->email = $data->email;
            $user->password = $data->password?Hash::make($data->password):$user->password;
            $user->nama_lengkap = $data->nama_lengkap;
            $user->pekerjaan = $data->pekerjaan;
            $user->no_telepon = $data->no_telepon;
            $user->nip = $data->nip;

            if ($data->has('avatar') && $data->avatar !== null) {
                try {
                    Storage::disk('public')->delete($user->avatar);

                    $image = $data->file('avatar');
                    $name = str_slug($data->input('nama_lengkap')).'_'.time();
                    $folder = '/uploads/avatar/';
                    $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                    $this->uploadOne($image, $folder, 'public', $name);
                    $user->avatar = $filePath;
                } catch (\Exception $e) {
                    return dtcApiResponse(500,false, $e->getMessage());
                }
            }

            try {
                $user->save();
                $user->avatar = $user->avatar?asset('storage'.$user->avatar):null;
                return dtcApiResponse(200,$user,responseMessage());
            } catch (QueryException $th) {
                return databaseExceptionError(implode(', ',$th->errorInfo));
            }

            return dtcApiResponse(200,$user);
        }
        else{
            return dtcApiResponse(404, false,'User tidak ditemukan');
        }
    }

    public function thread(){
        return $this->hasMany('App\Thread');
    }
}
