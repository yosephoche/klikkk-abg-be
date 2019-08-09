<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifikasiUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;
    public $staf_teknis;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengajuan, $stafTeknis)
    {
        $this->pengajuan = $pengajuan;
        $this->staf_teknis = $stafTeknis;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->staf_teknis)->subject('Verifikasi pengajuan oleh pemohon')
                    ->view('mail.verifikasiKepalaBalai');
    }
}
