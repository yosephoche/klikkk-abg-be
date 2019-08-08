<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifikasiKabidMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pengajuan;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->pengajuan->users)->subject('Perubahan status permohonan pengujian')
                    ->view('mail.verifikasiKabid');
    }
}
