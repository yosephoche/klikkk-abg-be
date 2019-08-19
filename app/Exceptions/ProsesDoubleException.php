<?php

namespace App\Exceptions;

use Exception;

class ProsesDoubleException extends Exception
{
    public function report()
    {
        \Log::debug('Proses double');
    }

    public function render($request)
    {
        return dtcApiResponse(500,null, 'Anda telah melakukan proses pada tahap ini, mohon untuk menunggu proses yang sedang berlangsung selesai');
    }
}
