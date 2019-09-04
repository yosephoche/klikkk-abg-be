<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User;
use App\Http\Requests\RegisterUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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
        if ($user = User::verifyUsersEmail($token)) {
            return view('mail.EmailConfirmed', compact('loginUrl', 'user'));
        }

        return view('mail.ConfirmationError');
    }

    public function forgetPassword(Request $request)
    {
        $user = new User();

        if (\App\Models\User::where('email', $request->email)->first()) {
            $user->sendResetLinkEmail($request);
            return Password::RESET_LINK_SENT
                    ? dtcApiResponse(200,null,'Email password reset berhasil dikirim')
                    : dtcApiResponse(500,null,'Terjadi kesalahan saat mengirim email');
        }
        else{
            return dtcApiResponse(404, null, 'User tidak di temukan');
        }
    }

    public function resetPassword(Request $request)
    {
        $res = Password::broker()->reset(
            $request->all(), function($user, $password)
            {
                $user->password = Hash::make($password);

                $user->setRememberToken(\Str::random(60));

                $user->save();
            }
        );


        return $res == Password::PASSWORD_RESET ? dtcApiResponse(200, '', 'Password berhasil di reset')
                                                : dtcApiResponse(404,'','User tidak ditemukan');
    }
}
