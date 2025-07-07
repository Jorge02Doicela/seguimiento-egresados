<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function inbox()
    {
        $user = auth()->user();
        $messages = $user->receivedMessages()->with('sender')->latest()->paginate(10);

        return view('messages.inbox', compact('messages'));
    }

    public function create()
    {
        // Lista de usuarios para enviar mensaje (ejemplo: admin envía a egresados)
        $users = User::where('id', '!=', auth()->id())->get();

        return view('messages.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'read' => false,
        ]);

        return redirect()->route('messages.inbox')->with('success', 'Mensaje enviado con éxito');
    }


    public function markAsRead(Message $message)
    {
        // Solo el receptor puede marcar como leído
        if ($message->receiver_id !== auth()->id()) {
            abort(403);
        }

        $message->update(['read' => true]);

        return back();
    }
}
