<?php

namespace App\Notifications;

use App\Mail\PengajuanDiTolakMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PengajuanDiTolakNotification extends Notification
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
        return (new PengajuanDiTolakMail($this->pengajuan,$notifiable));
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
            'title' => 'User telah menyetujui revisi pengajuan',
            'body' => 'Pemohon dengan nomor registrasi pengajuan '.$this->pengajuan->regId .'telah menolak untuk melanjutkan ke proses selanjutnya',
        ];
    }
}
