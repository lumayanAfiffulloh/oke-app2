<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $notifs = $user->notifications()->latest()->take(10)->get();
                $unreadCount = $user->unreadNotifications()->count();

                $view->with([
                    'dropdownNotifs' => $notifs,
                    'unreadCount' => $unreadCount,
                ]);
            }
        });
    }
}
