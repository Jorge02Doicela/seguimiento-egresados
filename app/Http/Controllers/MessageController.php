<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    // Mostrar bandeja de entrada (mensajes recibidos)
    public function inbox()
    {
        $userId = Auth::id();

        $messages = Message::with('sender')
            ->where('recipient_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('messages.inbox', compact('messages'));
    }

    // Mostrar formulario para crear nuevo mensaje con filtro según rol
    public function create()
    {
        $user = Auth::user();

        // Obtener destinatarios válidos según rol
        $allowedRecipients = $user->getAllowedRecipients();

        return view('messages.create', ['users' => $allowedRecipients]);
    }

    // Guardar mensaje validando roles permitidos
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'content' => ['required', 'string', 'max:1000'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt,pptx', 'max:5120'], // max 5MB y tipos permitidos
        ]);

        $sender = auth()->user();
        $receiverId = $request->input('receiver_id');

        $allowedRecipients = $sender->getAllowedRecipients()->pluck('id')->toArray();

        if (!in_array($receiverId, $allowedRecipients)) {
            return back()->withErrors(['receiver_id' => 'El destinatario seleccionado no es válido para su rol.'])->withInput();
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('messages', 'public');
        }

        Message::create([
            'sender_id' => $sender->id,
            'recipient_id' => $receiverId,
            'content' => $request->input('content'),
            'attachment_path' => $attachmentPath,
            'read_at' => null,
        ]);

        return redirect()->route('messages.inbox')->with('success', 'Mensaje enviado correctamente.');
    }

    // Mostrar mensaje individual (solo para remitente o receptor)
    public function show($id)
    {
        $user = Auth::user();

        $message = Message::with('sender', 'recipient')->findOrFail($id);

        if ($message->recipient_id !== $user->id && $message->sender_id !== $user->id) {
            abort(403, 'No tienes permiso para ver este mensaje.');
        }

        // Marcar como leído solo si es receptor y no estaba leído
        if ($message->recipient_id === $user->id && is_null($message->read_at)) {
            $message->read_at = now();
            $message->save();
        }

        return view('messages.show', compact('message'));
    }

    // Mostrar mensajes enviados
    public function sent()
    {
        $messages = Message::where('sender_id', Auth::id())
            ->with('recipient')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('messages.sent', compact('messages'));
    }

    // Marcar mensaje como leído (solo receptor)
    public function markAsRead($id)
    {
        $message = Message::where('id', $id)
            ->where('recipient_id', Auth::id())
            ->firstOrFail();

        if (is_null($message->read_at)) {
            $message->read_at = now();
            $message->save();
        }

        return redirect()->back();
    }

    // Eliminar mensaje
    public function destroy($id)
    {
        $userId = auth()->id();
        $message = Message::findOrFail($id);

        // Verificar que el usuario es remitente o receptor
        if ($message->sender_id !== $userId && $message->recipient_id !== $userId) {
            abort(403, 'No tienes permiso para eliminar este mensaje.');
        }

        $message->delete();

        return redirect()->route('messages.inbox')->with('success', 'Mensaje eliminado correctamente.');
    }

    // NUEVO: Descargar o visualizar archivo adjunto (solo remitente o destinatario)
    public function attachment($id)
    {
        $user = auth()->user();
        $message = Message::findOrFail($id);

        // Verificar que el usuario sea remitente o receptor
        if ($message->sender_id !== $user->id && $message->recipient_id !== $user->id) {
            abort(403, 'No tienes permiso para acceder a este archivo.');
        }

        // Verificar que exista el archivo adjunto
        if (!$message->attachment_path || !Storage::disk('public')->exists($message->attachment_path)) {
            abort(404, 'Archivo no encontrado.');
        }

        $filePath = storage_path('app/public/' . $message->attachment_path);
        $mimeType = Storage::disk('public')->mimeType($message->attachment_path);
        $fileName = basename($message->attachment_path);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }
}
