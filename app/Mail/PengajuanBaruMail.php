<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class PengajuanBaruMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;
    public $kepala_balai;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengajuan)
    {
        $this->pengajuan = $pengajuan;
        $kepala_balai = new \App\Models\User();

        $kepala_balai = $kepala_balai->whereHas('roles', function($q){
            $q->where('name', 'kepala_balai');
        })->first();

        $this->kepala_balai = $kepala_balai;
        // dd($this->pengajuan, $this->kepala_balai);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->kepala_balai)->subject('Pengajuan Permohonan Pengujian Baru')
                    ->view('mail.pengajuanPermohonanBaru');
    }
}
