<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Message;

class MessageController extends Controller
{
    public function index()
    {
        $message = new Message();

        return dtcApiResponse(200, $message->index());
    }
}
