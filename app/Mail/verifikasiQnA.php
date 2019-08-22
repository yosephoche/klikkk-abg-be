<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class verifikasiQnA extends Mailable
{
    use Queueable, SerializesModels;

    public $question;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($question)
    {
        $this->question = $question;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.verifikasiQnA')
                    ->with([
                        'data' => $this->question,
                    ]);
    }
}
