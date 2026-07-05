<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservaProcesada extends Notification
{
    use Queueable;

    protected $reserva;
    protected $estado;

    /**
     * Create a new notification instance.
     */
    public function __construct($reserva, $estado)
    {
        $this->reserva = $reserva;
        $this->estado = $estado;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'reserva_id' => $this->reserva->id,
            'cancha' => $this->reserva->cancha->nombre,
            'estado' => $this->estado,
            'fecha' => $this->reserva->fecha,
            'mensaje' => 'Tu reserva para ' . $this->reserva->cancha->nombre . ' ha sido ' . strtolower($this->estado) . '.',
        ];
    }
}
