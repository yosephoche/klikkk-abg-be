<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\commentMail;


class commentNotification extends Notification
{
    use Queueable;
    public $user;
    public $thread;
    public $comment;
    /**
     * Create a new notification instance.
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
        return (new commentMail($this->user,$this->thread,$this->comment))->to($this->user->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase ($notifiable)
    {
        return [
            'jenisNotification' => $this->thread->status,
            'judulThread' => $this->thread->subject,
            'commenter' => $this->comment->user->nama_lengkap,
        ];
    }
}
