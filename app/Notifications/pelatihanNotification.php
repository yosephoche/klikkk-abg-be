<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\trainingNotification as Mailable;

class pelatihanNotification extends Notification
{
    use Queueable;
    public $data;
    public $staff;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data,$staff)
    {
        $this->data = $data;
        $this->staff = $staff;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        foreach ($this->staff as $staff) {
            return (new MailMessage)->view('
                                mail.pelatihanNotification',
                                [   
                                    'staff' => $staff,
                                    'data' => $this->data,
                                ]);   
        }
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
            //
        ];
    }
}
