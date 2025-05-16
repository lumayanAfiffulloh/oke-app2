<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ValidatorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $rencana;
    protected $message;
    protected $type;
    protected $actionUrl;

    public function __construct($rencana, $message, $type, $actionUrl)
    {
        $this->rencana = $rencana;
        $this->message = $message;
        $this->type = $type;
        $this->actionUrl = $actionUrl;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'rencana_id' => $this->rencana->id,
            'pegawai_name' => $this->rencana->pegawai->name,
            'message' => $this->message,
            'type' => $this->type,
            'url' => $this->actionUrl,
            'time' => now()->toDateTimeString(),
        ];
    }
}