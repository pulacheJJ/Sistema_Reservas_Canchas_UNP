<?php

namespace App\Http\Controllers;

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
        $canchas = $this->canchaService->obtenerTodas();
        return view('alumno.inicio', compact('canchas'));
    }

    /**
     * Guarda una nueva solicitud de reserva.
     */
    public function store(StoreReservaRequest $request)
    {
        try {
            $this->reservaService->crearReserva($request->validated());

            return redirect()->route('reservas.inicio')->with('success', 'Tu reserva ha sido registrada y está en estado Pendiente.');
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

    /**
     * Muestra la vista del calendario general de reservas.
     */
    public function calendario()
    {
        $canchas = $this->canchaService->obtenerDisponibles();
        return view('alumno.calendario', compact('canchas'));
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
