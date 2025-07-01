<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $user = Auth::user();

        // Busca la notificación usando la relación notifications del usuario
        $notification = $user->notifications()->findOrFail($id);

        // Si la notificación no está marcada como leída, la marca como leída
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notificación marcada como leída');
    }
}
