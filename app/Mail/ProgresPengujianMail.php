<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProgresPengujianMail extends Mailable
{
    use Queueable, SerializesModels;

    public $progress;
    public $pengujian;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$pengujian,$progress)
    {
        $this->progress = $progress;
        $this->pengujian = $pengujian;
        // dd($user);
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->user);
        return $this->to($this->user)->subject('Progres Pengujian')->view('mail.progresPengujian');
    }
}
