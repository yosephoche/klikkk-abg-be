<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function changePassword(Request $request)
    {
        $user = auth('api')->user();
        if (Hash::make($request->old_password) == $user->password ) {
            $user->password = $request->new_password;
            $user->save();
        }
        else{
            return dtcApiResponse(401,null,'Password lama tidak sesuai');
        }

        return dtcApiResponse(200, null,'Password berhasil di ganti');
    }
}
