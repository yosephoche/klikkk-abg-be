<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadBuktiTransaksiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan, $user;
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
        return $this->to($this->user)->subject('Upload bukti transaksi')
                    ->view('mail.uploadBuktiTransaksi');
    }
}
