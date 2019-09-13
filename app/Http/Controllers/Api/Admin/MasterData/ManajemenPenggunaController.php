<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User;

class ManajemenPenggunaController extends Controller
{
    public function index(Request $request)
    {
        $user = new User();
        return $user->getAllUsers($request);
    }

    public function delete($id)
    {
        $user = new User();

        return $user->deleteUser($id);
    }

    // public function save(Request $request){
    //     $user = new User();
    //     return $user->registerAdmin($request);
    // }

    // public function edit($uuid)
    // {
    //     $user = new User();

    //     return $user->getAdmin($uuid);
    // }

    // public function update(Request $request)
    // {
    //     $user = new User();

    //     return $user->updateAdmin($request);
    // }
}
