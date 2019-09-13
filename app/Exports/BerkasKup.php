<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BerkasKup implements FromView
{
    public $pengajuan;

    public function __construct($pengajuapengajuan) {
        $this->pengajuan = $pengajuapengajuan;
    }

    public function view(): View
    {
        return view('berkas.template-kup', [
            'pengajuan' => $this->pengajuan
        ]);
    }
}
