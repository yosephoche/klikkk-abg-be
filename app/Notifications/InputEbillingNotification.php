<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\InputEbillingMail;

class InputEbillingNotification extends Notification
{
    use Queueable;

    public $pengajuan;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($this->pengajuan->users->email_notification) {
            return ['mail', 'database'];
        }
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

        return (new InputEbillingMail($this->pengajuan));
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
            'type' => 'message',
            'label' => 'Pembayaran',
            'title' => 'E-Billing',
            'nomor_registrasi' => $this->pengajuan->regId,
            'path' => '/pengajuan/pengujian/upload/bukti/'.$this->pengajuan->regId,
            'body' => 'Mohon lakukan pembayaran berdasarkan kode E-Billing'
        ];
    }
}
