<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ChannelManager::class, function ($app) {
            return new ChannelManager($app);
        });
    }

    public function boot()
    {
        Notification::extend('database', function ($app) {
            return $app->make(\Illuminate\Notifications\Channels\DatabaseChannel::class);
        });
    }
}