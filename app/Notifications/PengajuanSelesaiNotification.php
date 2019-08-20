<?php

namespace App\Notifications;

use App\Mail\PengajuanSelesaiMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PengajuanSelesaiNotification extends Notification
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
        if ($notifiable->email_notification) {
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
        return (new PengajuanSelesaiMail($notifiable, $this->pengajuan));
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
            'label' => 'pengujian',
            'nomor_registrasi' => $this->pengajuan->regId,
            'title' => 'Pengujian Selesai',
            'body' => 'Selamat, Pengujian dengan nomor registrasi'.$this->pengajuan->regId.' telah selesai',
            'path' => null
        ];
    }
}
