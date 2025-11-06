<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Get notifications for current user (or all for admin)
    public function index()
    {
        $user = Auth::user();
        $query = Notification::query();
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }
        $notifications = $query->latest()->take(10)->get();
        return response()->json($notifications);
    }

    // Mark notification as read
    public function markAsRead($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->is_read = true;
        $notif->save();
        return response()->json(['success' => true]);
    }
}
