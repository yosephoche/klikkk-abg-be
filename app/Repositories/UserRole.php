<?php

namespace App\Repositories;

use App\Repositories\Traits\ApiResponseTrait;

class UserRole
{

    use ApiResponseTrait;

    protected $role;
    protected $user;
    protected $user_role;

    public function __construct($user_id = null)
    {
        $this->user($user_id);
        $this->role();
    }

    public function where($id){
        $this->user = $this->user->where('id', $id)->orWhere('uuid', $id)->first();
        return $this;
    }

    public function user($id)
    {
        $user = new \App\Repositories\User();

        if ($id) {
            $user = $user->where('id', $id)->orWhere('uuid', $id)->first();
        }

        $this->user = $user;

        return $this;
    }

    public function role()
    {
        $role = new \App\Models\Role();

        $this->role = $role;

        return $this;
    }

    public function all(){
        $user = $this->user;
        // return $user->whereHas('roles')->get();
        return $user->where('jenis_akun', 1)->get()->map(function($value, $key){
            return [
                'uuid' => $value->uuid,
                'nama_lengkap' => $value->nama_lengkap,
                'role' => $value->roles()->get()->map(function($value, $key){
                    return [
                        'name' => $value->name
                    ];
                })
            ];
        });
    }

    public function attach($data){
        $user = $this->user->where('id', $data->id_user)->orWhere('uuid', $data->id_user)->first();

        return $this->apiResponse($user->roles()->attach($data->id_role));
    }

    public function detach($data){
        $user = $this->user->where('id', $data->id_user)->orWhere('uuid', $data->id_user)->first();

        return $this->apiResponse($user->roles()->detach($data->id_role));
    }

    public function getListUser(){
        $res = $this->user->admin()->get()->map(function($value, $key){
            return [
                'uuid' => $value->uuid,
                'nama_lengkap' => $value->nama_lengkap
            ];
        });

        return dtcApiResponse(200,$res);
    }

    public function getListRole(){
        $res = $this->role->all()->map(function($value, $key){
            return [
                'id' => $value->id,
                'name' => $value->display_name
            ];
        });

        return dtcApiResponse(200, $res);
    }
}