<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InputEbillingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;
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
        return $this->to($this->pengajuan->users)->subject('Kode E-Billing Pembayaran Pengujian')
                    ->view('mail.inputEbilling');
    }
}
