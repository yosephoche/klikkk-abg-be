<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class answerPostNotification extends Notification
{
    use Queueable;
    public $answer;
    public $question;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($answer, $question)
    {
        $this->answer = $answer;
        $this->question = $question;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'type'  => 'message',
            'label' => 'Pertanyaan',
            'title' => 'Menjawab Pertanyaan',
            'body'  => $this->answer->user->nama_lengkap.'Melakukan Reply Pada pertanyaan : '.$this->question->question,
            'path'  => 'panduan/pertanyaan/'.$this->question->id,
        ];
    }
}
