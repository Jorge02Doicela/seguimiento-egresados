<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
// Para email (opcional)
use Illuminate\Notifications\Messages\MailMessage;

class MessageNotification extends Notification
{
    use Queueable;

    protected $senderName;      // Nombre del remitente del mensaje
    protected $messageContent;  // Texto del mensaje

    /**
     * Constructor: recibe datos para la notificación
     */
    public function __construct($senderName, $messageContent)
    {
        $this->senderName = $senderName;
        $this->messageContent = $messageContent;
    }

    /**
     * Define los canales para entregar la notificación
     */
    public function via($notifiable)
    {
        return ['database'];  // También puede incluir 'mail', 'broadcast', etc.
    }

    /**
     * Contenido para almacenar en la base de datos
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Nuevo mensaje recibido',
            'sender' => $this->senderName,
            'message' => $this->messageContent,
        ];
    }

    /**
     * Opcional: Cómo enviar por email (si quieres activar mail)
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nuevo mensaje recibido')
            ->line("Has recibido un mensaje de {$this->senderName}.")
            ->line($this->messageContent)
            ->action('Ver mensajes', url('/messages'))
            ->line('Gracias por usar nuestra aplicación!');
    }
}
