<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationAdminController extends Controller
{
    public function notification()
    {
        $admin = User::where('role', 'admin')->first();
        $notifications = $admin->notifications()->get();
        $unreadCount = $admin->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function markAsRead()
    {
        $admin = User::where('role', 'admin')->first();
        $admin->unreadNotifications->markAsRead();

        return response()->json([
            'message' => 'All notifications marked as read',
        ]);
    }
}
