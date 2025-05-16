<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RencanaPembelajaranNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $link;
    protected $type;

    public function __construct($type, $message, $link = null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->link = $link;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
            'link' => $this->link,
            'time' => now()->toDateTimeString(),
        ];
    }
}