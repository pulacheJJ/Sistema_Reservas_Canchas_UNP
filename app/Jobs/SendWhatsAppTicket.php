<?php

namespace App\Jobs;

use App\Models\Reserva;
use App\Services\WhatsAppService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SendWhatsAppTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reserva;

    /**
     * Create a new job instance.
     */
    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsAppService): void
    {
        try {
            // 1. Generar PDF usando la vista (lo guardamos por si queremos descargarlo después desde el panel)
            $pdf = Pdf::loadView('tickets.reserva', ['reserva' => $this->reserva]);
            
            $filename = 'ticket_reserva_' . $this->reserva->id . '.pdf';
            $path = 'public/tickets/' . $filename;
            
            Storage::put($path, $pdf->output());

            // 2. Enviar vía WhatsApp (Solo texto para evitar error de localhost)
            $telefono = $this->reserva->user->telefono ?? env('WHATSAPP_TEST_NUMBER');
            
            if ($telefono) {
                // Formatear fechas para mejor lectura
                $fechaStr = \Carbon\Carbon::parse($this->reserva->fecha)->format('d/m/Y');
                $horaInicioStr = \Carbon\Carbon::parse($this->reserva->hora_inicio)->format('H:i');
                $horaFinStr = \Carbon\Carbon::parse($this->reserva->hora_fin)->format('H:i');

                $mensaje = "🏅 *UNP DEPORTES - RESERVA CONFIRMADA*\n\n"
                         . "¡Hola {$this->reserva->user->name}!\n"
                         . "Tu solicitud ha sido procesada con éxito.\n\n"
                         . "📍 *Cancha:* {$this->reserva->cancha->nombre}\n"
                         . "📅 *Fecha:* {$fechaStr}\n"
                         . "⏰ *Horario:* {$horaInicioStr} a {$horaFinStr}\n\n"
                         . "ID de Ticket: #TKT-".str_pad($this->reserva->id, 5, '0', STR_PAD_LEFT)."\n"
                         . "Por favor, acércate a la instalación en tu horario establecido.";

                // Usamos enviarMensaje en lugar de enviarDocumento
                $whatsAppService->enviarMensaje($telefono, $mensaje);
            } else {
                Log::warning('No se pudo enviar WhatsApp porque el usuario no tiene teléfono registrado y no hay número de prueba (WHATSAPP_TEST_NUMBER) configurado.');
            }

        } catch (\Exception $e) {
            Log::error('Error en SendWhatsAppTicket: ' . $e->getMessage());
        }
    }
}
