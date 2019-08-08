<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class commentMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user,$thread,$comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $thread, $comment)
    {
        $this->user = $user;
        $this->thread = $thread;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.commentNotification')
                    ->with([
                        'greeting' => $this->user,
                        'thread' => $this->thread,
                        'comment' => $this->comment->user,
                    ]);
    }
}
