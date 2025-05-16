<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications ?? [];
        return Inertia::render('Admin/Notifications/Index', [
            'notifications' => $notifications,
        ]);
    }

    public function userNotifications()
    {
        $notifications = Auth::user()->notifications ?? [];
        return Inertia::render('Home/Notifications/Index', [
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead($notificationId)
    {
        Auth::user()->unreadNotifications->where('id', $notificationId)->markAsRead();
        return back();
    }
}
