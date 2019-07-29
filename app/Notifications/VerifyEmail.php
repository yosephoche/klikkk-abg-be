<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\VerifyEmail as EmailVerification;

class VerifyEmail extends Notification
{
    use Queueable;

    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        return (new EmailVerification($this->user));
                    // ->subject('Verifikasi email anda')
                    // ->markdown('mail.confirmation',['user' => $this->user]);
                    // ->subject('Verifikasi email anda')
                    // ->line('Klikk ABG')
                    // ->action('Konfirmasi', route('api.verifyUsersEmail', $this->user->emailVerification()->first()->token ))
                    // ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_email' => $this->user->email,
            'token' => $this->user->emailVerification()->first()->token
        ];
    }
}
