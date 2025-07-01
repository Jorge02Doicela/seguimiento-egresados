<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;  // Email (opcional)
use App\Models\Survey;

class NewSurveyNotification extends Notification
{
    use Queueable;

    protected $surveyTitle;

    /**
     * Crear una nueva instancia de notificación.
     */
    public function __construct($surveyTitle)
    {
        $this->surveyTitle = $surveyTitle;
    }

    /**
     * Canales de entrega: base de datos.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Representación para almacenamiento en base de datos.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Nueva encuesta creada',
            'message' => "Se ha creado una nueva encuesta: {$this->surveyTitle}",
        ];
    }
}
