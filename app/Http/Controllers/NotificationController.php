<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        return view('graduate.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = DatabaseNotification::findOrFail($id);
        if ($notification->notifiable_id == Auth::id()) {
            $notification->markAsRead();
        }

        return redirect()->route('graduate.notifications.index')->with('success', 'Notificación marcada como leída.');
    }
}
