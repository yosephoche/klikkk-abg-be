<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class trainingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $staff;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($staff,$data)
    {
        $this->data = $data;
        $this->staff = $staff;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.pelatihanNotification');
    }
}
