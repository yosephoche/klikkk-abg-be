<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\threadMail as emailNotification;

class threadMailNotification extends Notification
{
    use Queueable;
    protected $thread;
    protected $user;
    protected $comment;
    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($thread,$user,$comment,$reply)
    {
        $this->thread = $thread;
        $this->user = $user;
        $this->comment = $comment;
        $this->reply = $reply;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new emailNotification($this->user,$this->thread,$this->comment,$this->reply));
        // ->greeting('HI '.$this->thread->user->nama_lengkap)
                    // ->line('The introduction to the notification.')
                    // ->action('Notification Action', url('/'))
                    // ->line('Thank you for using our application!')
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'jenisNotification' => $this->thread->status,
            'replier' => $this->reply->user->nama_lengkap,
            'judulThread' => $this->thread->subject,
        ];
    }
}
