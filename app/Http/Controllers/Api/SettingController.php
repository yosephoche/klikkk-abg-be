<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Repositories\User as AppUser;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function changePassword(Request $request)
    {
        $user = auth('api')->user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
        }
        else{
            return dtcApiResponse(401,null,'Password lama tidak sesuai');
        }

        return dtcApiResponse(200, null,'Password berhasil di ganti');
    }

    public function changeName(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if(isset($user))
        {
            $user->nama_lengkap = $request->nama;
            $user->save();
            return dtcApiResponse(200,'Success','Nama Berhasil Di Ubah');            
        } else {
            return dtcApiResponse(404, null,'User Tidak Di temukan');        
        }
    }


    public function emailNotification(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if(isset($user))
        {
            if($user->email_notification == '1')
            {
                $user->email_notification = '0';
                $user->save();
                return dtcApiResponse(200,'false','Email Notification Di Nonaktifkan');
            } else {
                $user->email_notification = '1';
                $user->save();
                return dtcApiResponse(200,'true','Email Notification Di aktifkan');
            }
        } else {
            return dtcApiResponse(404, null,'User Tidak Di temukan');
        }
    }

    public function changeAvatar(Request $request)
    {
        $user = new AppUser();

        return dtcApiResponse(200, $user->uploadAvatar($request), 'Avatar berhasil di update');
    }
}
