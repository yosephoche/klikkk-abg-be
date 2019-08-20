<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\VerifikasiKabidMail;

class VerifikasiKabid extends Notification
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
        return (new VerifikasiKabidMail($this->pengajuan));
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
            'nomor_registrasi' => $this->pengajuan->regId,
            'title' => 'Verifikasi Kepala Bidang',
            'path' => 'pengajuan/pengujian/verifikasi/'.$this->pengajuan->regId,
            'body' => 'Permohonan anda telah di periksa oleh pihak K3. Silahkan periksa kembali permohonan anda, lalu terima/revisi/tolak permohonan yang anda ajukan'
        ];
    }
}
