<?php

namespace App\Notifications;

use App\Mail\ProgresPengujianMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProgresPengujianNotification extends Notification
{
    use Queueable;

    public $pengajuan;
    public $progressBefore;
    public $progressNow;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pengajuan)
    {
        $this->pengajuan = $pengajuan;
        $this->progress();
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
        // $user = \App\Models\User::findOrFail($notifiable);

        return (new ProgresPengujianMail($notifiable,$this->pengajuan,['before' => $this->progressBefore, 'now' => $this->progressNow]));
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
            'title' => 'Update Progress Pengujian',
            'body' => 'Selamat, Pengujian anda dengan nomor registrasi '.$this->pengajuan->regId.' sudah berubah status dari '.$this->progressBefore->nama.' ke '.$this->progressNow->nama,
            'path' => null
        ];
    }

    public function progress()
    {
        $pengajuan = $this->pengajuan;
        $proses = $pengajuan->prosesPengajuan->sortBy('created_at');
        $countProgress = $proses->count()-1;

        $progressNow = $proses->offsetGet($countProgress);
        $progressBefore = $proses->offsetGet($countProgress-1);

        $this->progressBefore = $progressBefore->tahapPengajuan;
        $this->progressNow = $progressNow->tahapPengajuan;
    }
}
