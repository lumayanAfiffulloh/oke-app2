<?php

// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function dropdown()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        $unreadCount = $user->unreadNotifications()->count();
        
        return view('partials.notification_dropdown', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    public function markAsRead($id)
    {
        Auth::user()->notifications()
            ->where('id', $id)
            ->update(['read_at' => now()]);
            
        return redirect()->back();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()
            ->update(['read_at' => now()]);
            
        return redirect()->back();
    }

    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('notifications.index', compact('notifications'));
    }

    protected function getNotificationIcon($type)
    {
        $icons = [
            'deadline_reminder' => 'clock-alert',
            'deadline_passed' => 'clock-exclamation',
            'status_update' => 'status-change',
            'validation_required' => 'shield-check',
            'default' => 'bell'
        ];
        
        return $icons[$type] ?? $icons['default'];
    }
}