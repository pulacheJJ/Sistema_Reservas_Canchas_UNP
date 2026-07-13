<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Http\Requests\StoreReservaRequest;
use App\Models\Cancha;
use App\Services\CanchaService;
use App\Services\ReservaService;
use Exception;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function __construct(
        protected ReservaService $reservaService,
        protected CanchaService $canchaService
    ) {}

    /**
     * Muestra la vista principal (catálogo) para realizar reservas.
     */
    public function inicio()
    {
        $canchasAgrupadas = $this->canchaService->obtenerTodas()->groupBy('ubicacion');
        return view('alumno.inicio', compact('canchasAgrupadas'));
    }

    /**
     * Guarda una nueva solicitud de reserva.
     */
    public function store(StoreReservaRequest $request)
    {
        try {
            $this->reservaService->crearReserva($request->validated());

            return redirect()->route('reservas.inicio')->with('success', 'Tu reserva ha sido registrada exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancelar(Reserva $reserva)
    {
        try {
            $this->reservaService->cancelarReservaEstudiante($reserva, auth()->id());
            return back()->with('success', 'Tu reserva ha sido cancelada exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Muestra el historial de reservas del usuario.
     */
    public function misReservas()
    {
        $reservas = $this->reservaService->obtenerHistorialUsuario(Auth::id());
        return view('alumno.mis-reservas', compact('reservas'));
    }

    public function calendario()
    {
        $canchas = $this->canchaService->obtenerDisponibles();
        
        // Obtener todos los eventos para mostrarlos inicialmente en el calendario general
        $reservasAprobadas = \App\Models\Reserva::whereIn('estado', ['Aprobada', 'Pendiente'])->get();
        
        $eventos = [];
        foreach ($reservasAprobadas as $reserva) {
            $color = '#3b82f6';
            if ($reserva->is_evento) {
                $color = '#7c3aed';
            } elseif ($reserva->estado === 'Aprobada') {
                $color = '#10b981';
            } elseif ($reserva->estado === 'Pendiente') {
                $color = '#f59e0b';
            }
            
            $eventos[] = [
                'cancha_id' => $reserva->cancha_id,
                'title' => $reserva->is_evento ? '🏅 ' . $reserva->titulo_evento : 'Reserva ' . $reserva->estado,
                'start' => $reserva->fecha . 'T' . $reserva->hora_inicio,
                'end' => $reserva->fecha . 'T' . $reserva->hora_fin,
                'color' => $color,
                'estado' => $reserva->estado,
                'display' => 'block'
            ];
        }

        return view('alumno.calendario', compact('canchas', 'eventos'));
    }

    /**
     * API JSON: Devuelve las reservas aprobadas de una cancha para FullCalendar.
     */
    public function apiHorarios(Cancha $cancha)
    {
        $eventos = $this->reservaService->obtenerEventosCalendario($cancha->id);
        return response()->json($eventos);
    }
}
