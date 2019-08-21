<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User;
use App\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $user = new User();
        return $user->getAllAdmin();
    }

    public function save(Request $request){
        $user = new User();
        return $user->registerAdmin($request);
    }

    public function edit($uuid)
    {
        $user = new User();

        return $user->getAdmin($uuid);
    }

    public function update(Request $request)
    {
        $user = new User();

        return $user->updateAdmin($request);
    }

    public function delete($id)
    {
        $user = new User();

        return $user->deleteUser($id);
    }
}
