<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PlanNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $type;
    protected $planId;

    public function __construct($message, $type, $planId = null)
    {
        $this->message = $message;
        $this->type = $type;
        $this->planId = $planId;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
            'plan_id' => $this->planId,
            'time' => now()->toDateTimeString(),
        ];
    }
}