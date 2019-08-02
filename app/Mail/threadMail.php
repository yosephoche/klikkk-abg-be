<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class threadMail extends Mailable
{
    use Queueable, SerializesModels;


    public $user;
    public $thread;
    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$thread,$comment)
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
        return $this->to($this->user)
                    ->with([
                        'greeting' => $this->comment->user->nama_lengkap,
                        // 'thread' => $this->thread->id,
                        'replier' => $this->comment->user->nama_lengkap,
                    ])
                    ->view('mail.replyNotification');
    }
}
