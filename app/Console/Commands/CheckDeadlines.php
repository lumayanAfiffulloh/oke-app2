<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class CheckDeadlines extends Command
{
    protected $signature = 'check:deadlines';
    protected $description = 'Check for upcoming deadlines and send notifications';

    public function handle(NotificationService $notificationService)
    {
        $notificationService->checkDeadlines();
        $this->info('Deadline checks completed.');
    }
}