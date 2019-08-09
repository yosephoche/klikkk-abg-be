<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PengajuanDiSetujuiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengajuan, $user)
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
        return $this->to($this->user)->subject('Pengajuan disetujui oleh user')
                    ->view('mail.pengajuanDisetujui');
    }
}
