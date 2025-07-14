<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateProfileNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Actualiza tu perfil',
            'message' => 'El administrador solicita que actualices tus datos en el sistema.',
            'action' => route('profile.edit'), // puedes ajustar según sea egresado o empleador
        ];
    }
}
