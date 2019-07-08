<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRole;

class UserRoleController extends Controller
{
    protected $userRole ;

    public function __construct()
    {
        $this->userRole = new UserRole();
    }

    public function index(){
        return dtcApiResponse(200,$this->userRole->all());
    }

    public function attach(Request $request){
        return $this->userRole->attach($request);
    }

    public function detach(Request $request){
        return $this->userRole->detach($request);
    }

    public function getListUser(){
        return $this->userRole->getListUser();
    }

    public function getListRole(){
        return $this->userRole->getListRole();
    }
}
