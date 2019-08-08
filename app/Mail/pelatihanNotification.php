<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class pelatihanNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$staff)
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
        return $this->view('mail.pelatihanNotification')
                    ->with([
                        'greeting' => $this->staff,
                        'data' => $this->data,
                        'jenisPelatihan' => $this->data->jenisPelatihan,
                    ]);
    }
}
