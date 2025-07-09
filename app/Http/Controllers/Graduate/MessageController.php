<?php

namespace App\Http\Controllers\Graduate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Mostrar bandeja de entrada con mensajes recibidos paginados
    public function index()
    {
        $user = Auth::user();

        // Traer mensajes recibidos del usuario autenticado, ordenados por fecha descendente
        $messages = Message::where('receiver_id', $user->id)
            ->with('sender') // para acceder al nombre del remitente en la vista
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('messages.inbox', compact('messages'));
    }

    // Mostrar formulario para enviar mensaje
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get(); // no incluir al usuario actual

        return view('messages.create', compact('users'));
    }

    // Guardar mensaje en BD
    public function store(Request $request)
    {
        // Validaciones básicas
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'read' => false,
        ]);

        return redirect()->route('messages.index')->with('success', 'Mensaje enviado correctamente');
    }

    // Marcar un mensaje como leído
    // Marcar un mensaje como leído
    public function markAsRead($id)
    {
        $user = Auth::user();

        // Convertir $id a entero para blindar contra inyección y errores
        $id = (int) $id;

        // Buscar el mensaje asegurando que pertenece al usuario autenticado
        $message = Message::where('id', $id)
            ->where('receiver_id', $user->id)
            ->firstOrFail();

        // Marcar como leído si aún no lo está
        if (!$message->read) {
            $message->read = true;
            $message->save();
        }

        return redirect()->back()->with('success', 'Mensaje marcado como leído');
    }
}
