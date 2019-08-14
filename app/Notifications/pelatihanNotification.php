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
        if($this->staff->email_notification == 1)
        {
            return ['mail','database'];
        } else  {
            return ['database'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->view('
                            mail.pelatihanNotification',
                            [   
                                'staff' => $this->staff,
                                'data' => $this->data,
                            ]);   
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
            'type' => "notification",
            'label' => "Pengajuan",
            'title' => "Permohonan Pengajuan Pelatihan",
            'path' => route('show.pelatihan',['id' => $this->thread->id]),
        ];
    }
}
