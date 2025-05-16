<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PegawaiRencanaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $rencana;
    protected $message;
    protected $type;

    public function __construct($rencana, $message, $type)
    {
        $this->rencana = $rencana;
        $this->message = $message;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'rencana_id' => $this->rencana->id,
            'message' => $this->message,
            'type' => $this->type,
            'url' => route('pegawai.rencana.show', $this->rencana->id),
            'time' => now()->toDateTimeString(),
        ];
    }
}