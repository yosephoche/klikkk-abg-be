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
    public $reply;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$thread,$comment,$reply)
    {
        $this->user = $user;
        $this->thread = $thread;
        $this->comment = $comment;
        $this->reply = $reply;
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
                        'commenter' => $this->comment->user->nama_lengkap,
                        'replier' => $this->reply->user->nama_lengkap,
                    ])
                    ->view('mail.replyNotification');
    }
}
