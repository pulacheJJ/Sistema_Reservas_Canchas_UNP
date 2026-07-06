<?php

namespace App\Services;

use App\Models\Reserva;
use App\Models\Sancion;
use App\Models\User;
use App\Notifications\ReservaProcesada;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class ReservaService
{
    /**
     * Crea una reserva tras validar sanciones.
     * @throws Exception Si el usuario está sancionado.
     */
    public function crearReserva(array $data)
    {
        $userId = Auth::id();

        // Verificar si el usuario está sancionado
        $sancionActiva = Sancion::where('user_id', $userId)
            ->where('fecha_fin', '>=', now())
            ->first();

        if ($sancionActiva) {
            throw new Exception('No puedes realizar reservas porque tienes una sanción activa hasta el ' . Carbon::parse($sancionActiva->fecha_fin)->format('d/m/Y') . '. Motivo: ' . $sancionActiva->motivo);
        }

        // Verificar superposición de horarios (Cancha ocupada o con reserva pendiente)
        $superposicion = Reserva::where('cancha_id', $data['cancha_id'])
            ->where('fecha', $data['fecha'])
            ->whereIn('estado', ['Pendiente', 'Aprobada'])
            ->where(function($query) use ($data) {
                $query->where('hora_inicio', '<', $data['hora_fin'])
                      ->where('hora_fin', '>', $data['hora_inicio']);
            })
            ->exists();

        if ($superposicion) {
            throw new Exception('La cancha ya se encuentra reservada o tiene una solicitud en proceso para este horario.');
        }

        return Reserva::create([
            'user_id' => $userId,
            'cancha_id' => $data['cancha_id'],
            'fecha' => $data['fecha'],
            'hora_inicio' => $data['hora_inicio'],
            'hora_fin' => $data['hora_fin'],
            'estado' => 'Pendiente',
        ]);
    }

    /**
     * Obtiene el historial de reservas de un usuario.
     */
    public function obtenerHistorialUsuario($userId)
    {
        return Reserva::where('user_id', $userId)
            ->with('cancha')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Actualiza el estado de la reserva y notifica al usuario.
     */
    public function actualizarEstado(Reserva $reserva, string $estado)
    {
        $reserva->update(['estado' => $estado]);

        $mensaje = $estado === 'Aprobada'
            ? 'Tu reserva para el ' . Carbon::parse($reserva->fecha)->format('d/m/Y') . ' ha sido aprobada.'
            : 'Tu reserva para el ' . Carbon::parse($reserva->fecha)->format('d/m/Y') . ' ha sido rechazada.';

        // Notificar al usuario (via notificaciones de BD)
        $reserva->user->notify(new ReservaProcesada($reserva, $mensaje));

        return $reserva;
    }

    /**
     * Aplica una sanción a un usuario.
     */
    public function sancionarUsuario(array $data)
    {
        return Sancion::create([
            'user_id' => $data['user_id'],
            'motivo' => $data['motivo'],
            'fecha_inicio' => now(),
            'fecha_fin' => $data['fecha_fin'],
        ]);
    }

    /**
     * Crea un bloqueo de cancha por evento.
     */
    public function crearEvento(array $data)
    {
        return Reserva::create([
            'user_id' => Auth::id(), // El admin crea el evento
            'cancha_id' => $data['cancha_id'],
            'fecha' => $data['fecha'],
            'hora_inicio' => '06:00:00',
            'hora_fin' => '23:00:00',
            'estado' => 'Aprobada',
            'is_evento' => true,
            'titulo_evento' => $data['titulo_evento']
        ]);
    }

    /**
     * Devuelve las reservas formateadas para FullCalendar.
     */
    public function obtenerEventosCalendario(int $canchaId)
    {
        $reservasAprobadas = Reserva::where('cancha_id', $canchaId)
            ->where('estado', 'Aprobada')
            ->get();
        
        $eventos = [];
        foreach ($reservasAprobadas as $reserva) {
            $eventos[] = [
                'title' => $reserva->is_evento ? '🏅 ' . $reserva->titulo_evento : 'Ocupado',
                'start' => $reserva->fecha . 'T' . $reserva->hora_inicio,
                'end' => $reserva->fecha . 'T' . $reserva->hora_fin,
                'color' => $reserva->is_evento ? '#7c3aed' : '#dc2626',
                'display' => 'block'
            ];
        }

        return $eventos;
    }

    /**
     * Permite a un estudiante cancelar su propia reserva si faltan más de 2 horas.
     */
    public function cancelarReservaEstudiante(Reserva $reserva, $userId)
    {
        if ($reserva->user_id !== $userId) {
            throw new \Exception('No tienes permiso para cancelar esta reserva.');
        }

        if ($reserva->estado === 'Cancelada') {
            throw new \Exception('La reserva ya se encuentra cancelada.');
        }

        // Verificar regla de 2 horas de anticipación
        $fechaHoraInicio = \Carbon\Carbon::parse($reserva->fecha . ' ' . $reserva->hora_inicio);
        if (now()->diffInHours($fechaHoraInicio, false) < 2) {
            throw new \Exception('Solo puedes cancelar una reserva con al menos 2 horas de anticipación.');
        }

        $reserva->update(['estado' => 'Cancelada']);

        return $reserva;
    }
}
