<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\VerifikasiUserMail;

class VerifikasiUserNotification extends Notification
{
    use Queueable;

    public $pengajuan;
    public $staf_teknis;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pengajuan, $stafTeknis)
    {
        $this->pengajuan = $pengajuan;
        $this->staf_teknis = $stafTeknis;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new VerifikasiUserMail($this->pengajuan, $this->staf_teknis));
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
            'type' => 'notification',
            'title' => 'verifikasi pengajuan oleh pemohon',
            'body' => 'Pengajuan baru dengan nomor registrasi '.$this->pengajuan->regId.' Menunggu verifikasi dari anda'
        ];
    }
}
