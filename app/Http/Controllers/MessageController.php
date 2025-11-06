<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Get messages for current user
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('to_user_id', $user->id)
            ->latest()->take(10)->get();
        return response()->json($messages);
    }

    // Send message
    public function store(Request $request)
    {
        $user = Auth::user();
        $msg = Message::create([
            'from_user_id' => $user->id,
            'to_user_id' => $request->to_user_id,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);
        return response()->json(['success' => true, 'data' => $msg]);
    }

    // Mark as read
    public function markAsRead($id)
    {
        $msg = Message::findOrFail($id);
        $msg->is_read = true;
        $msg->save();
        return response()->json(['success' => true]);
    }
}
