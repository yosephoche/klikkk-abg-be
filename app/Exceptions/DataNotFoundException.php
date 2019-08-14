<?php

namespace App\Exceptions;

use Exception;

class DataNotFoundException extends Exception
{
    public function report()
    {
        \Log::debug($this->message);
    }

    public function render($request)
    {
        return dtcApiResponse(404,null, $this->message);
    }
}
