<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User;
use App\Http\Requests\RegisterUser;

class AuthController extends Controller
{
    public function register (RegisterUser $request) {
        $user = new User();
        return $user->register($request);
    }

    public function login (Request $request) {
        $user = new User();

        return $user->login($request);
    }

    public function logout (Request $request) {
        return User::logout($request);
    }

    public function getRegisterData(){
        return User::getRegisterData();
    }

    public function verifyUsersEmail($token){

        $loginUrl = env('FE_LOGIN_URL');
        if (User::verifyUsersEmail($token)) {
            return view('mail.EmailConfirmed', compact('loginUrl'));
        }
    }
}
