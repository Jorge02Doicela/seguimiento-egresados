<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;


class NewSurveyNotification extends Notification
{
    use Queueable;

    protected $survey;

    public function __construct($survey)
    {
        $this->survey = $survey;
    }

    public function via($notifiable)
    {
        return ['database',];
    }


    public function toDatabase($notifiable)
    {
        return [
            'survey_id' => $this->survey->id,
            'title' => $this->survey->title,
            'message' => 'Hay una nueva encuesta disponible para responder.',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nueva encuesta disponible')
            ->greeting('Hola ' . $notifiable->name)
            ->line('Tienes una nueva encuesta que responder en el sistema de Seguimiento de Egresados.')
            ->action('Ver encuestas', url('/surveys'))
            ->line('Gracias por tu participación.');
    }
}
