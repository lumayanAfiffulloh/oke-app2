<?php

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TenggatRencanaNotification extends Notification
{
    protected $pesan;

    public function __construct($pesan)
    {
        $this->pesan = $pesan;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'pesan' => $this->pesan,
            'url' => route('rencana_pembelajaran.index') // arahkan ke halaman terkait
        ];
    }
}


