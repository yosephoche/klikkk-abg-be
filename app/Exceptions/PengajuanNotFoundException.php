<?php

namespace App\Exceptions;

use Exception;

class PengajuanNotFoundException extends Exception
{

    public function report()
    {
        \Log::debug('Pengajuan tidak ditemukan');
    }

    public function render($request)
    {
        // dd($this);
        return dtcApiResponse(404,null, 'Pengajuan tidak ditemukan');
    }
}
