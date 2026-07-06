<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\StoreSancionRequest;
use App\Http\Requests\UpdateEstadoReservaRequest;
use App\Models\Reserva;
use App\Services\ReservaService;

class AdminController extends Controller
{
    public function __construct(
        protected ReservaService $reservaService
    ) {}

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
    public function actualizarEstadoReserva(UpdateEstadoReservaRequest $request, Reserva $reserva)
    {
        $this->reservaService->actualizarEstado($reserva, $request->estado);
        return back()->with('success', 'El estado de la reserva ha sido actualizado a: ' . $request->estado);
    }

    /**
     * Sanciona a un usuario.
     */
    public function sancionar(StoreSancionRequest $request)
    {
        $this->reservaService->sancionarUsuario($request->validated());
        return back()->with('success', 'El alumno ha sido sancionado correctamente.');
    }

    /**
     * Crea un bloqueo de cancha por evento/torneo.
     */
    public function crearEvento(StoreEventoRequest $request)
    {
        $this->reservaService->crearEvento($request->validated());
        return back()->with('success', 'La cancha ha sido bloqueada exitosamente para el evento: ' . $request->titulo_evento);
    }
}
