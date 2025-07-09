<?php

namespace App\Http\Controllers\Graduate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Mostrar listado de notificaciones paginadas
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    // Marcar notificación como leída
    public function markAsRead($id)
    {
        $user = Auth::user();

        // Sanitizar ID: convertir a entero para blindar aún más
        $id = (int) $id;

        $notification = $user->notifications()->findOrFail($id);

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notificación marcada como leída');
    }
}
