<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PengajuanSelesaiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pengajuan;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$pengajuan)
    {
        $this->pengajuan = $pengajuan;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user)->subject('Pengujian Selesai')->view('mail.pengujianSelesai');
    }
}
