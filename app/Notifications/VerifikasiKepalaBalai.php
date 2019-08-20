<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\VerifikasiKepalaBalai as VerifikasiKepalaBalaiMail;

class VerifikasiKepalaBalai extends Notification
{
    use Queueable;

    protected $pengajuan;
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
        return ( new VerifikasiKepalaBalaiMail($this->pengajuan));
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
            'label' => 'Pengujian',
            'title' => 'Verifikasi Kepala Balai',
            'nomor_registrasi' => $this->pengajuan->regId,
            'path' => 'pengajuan/pengujian/view/'.$this->pengajuan->regId,
            'body' => 'Selamat, permohonan pengujian kamu telah di verifikasi oleh kepalai balai K3'
        ];
    }
}
