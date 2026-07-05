<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reserva;
use App\Notifications\ReservaProcesada;

class AdminController extends Controller
{
    /**
     * Muestra el panel principal del administrador.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Lista todas las reservas del sistema.
     */
    public function reservas()
    {
        $reservas = Reserva::with(['user', 'cancha'])->orderBy('created_at', 'desc')->get();
        return view('admin.reservas', compact('reservas'));
    }

    /**
     * Actualiza el estado de una reserva (Aprobar/Rechazar).
     */
    public function actualizarEstadoReserva(Request $request, Reserva $reserva)
    {
        $request->validate([
            'estado' => 'required|in:Aprobada,Rechazada'
        ]);

        $reserva->update([
            'estado' => $request->estado
        ]);

        // Enviar notificación al usuario
        $reserva->user->notify(new ReservaProcesada($reserva, $request->estado));

        return back()->with('success', 'El estado de la reserva ha sido actualizado a: ' . $request->estado);
    }

    /**
     * Sanciona a un usuario.
     */
    public function sancionar(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'motivo' => 'required|string|max:255',
            'fecha_fin' => 'required|date|after:today',
        ]);

        \App\Models\Sancion::create([
            'user_id' => $request->user_id,
            'motivo' => $request->motivo,
            'fecha_fin' => $request->fecha_fin
        ]);

        return back()->with('success', 'El alumno ha sido sancionado correctamente y no podrá realizar reservas hasta ' . \Carbon\Carbon::parse($request->fecha_fin)->format('d/m/Y'));
    }

    /**
     * Crea un bloqueo de cancha por evento/torneo.
     */
    public function crearEvento(Request $request)
    {
        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date|after_or_equal:today',
            'titulo_evento' => 'required|string|max:255',
        ]);

        Reserva::create([
            'user_id' => auth()->id(), // El admin crea el evento
            'cancha_id' => $request->cancha_id,
            'fecha' => $request->fecha,
            'hora_inicio' => '06:00:00',
            'hora_fin' => '23:00:00',
            'estado' => 'Aprobada',
            'is_evento' => true,
            'titulo_evento' => $request->titulo_evento
        ]);

        return back()->with('success', 'La cancha ha sido bloqueada exitosamente para el evento: ' . $request->titulo_evento);
    }
}
