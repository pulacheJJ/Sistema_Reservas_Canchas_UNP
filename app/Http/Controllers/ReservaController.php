<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cancha;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    /**
     * Muestra la vista principal (catálogo) para realizar reservas.
     */
    public function inicio()
    {
        $canchas = Cancha::all();
        return view('reservas.inicio', compact('canchas'));
    }

    /**
     * Guarda una nueva solicitud de reserva.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);

        // Verificar si el usuario está sancionado
        $sancionActiva = \App\Models\Sancion::where('user_id', Auth::id())
            ->where('fecha_fin', '>=', now())
            ->first();

        if ($sancionActiva) {
            return back()->withErrors(['loginError' => 'No puedes realizar reservas porque tienes una sanción activa hasta el ' . \Carbon\Carbon::parse($sancionActiva->fecha_fin)->format('d/m/Y') . '. Motivo: ' . $sancionActiva->motivo]);
        }

        Reserva::create([
            'user_id' => Auth::id(),
            'cancha_id' => $request->cancha_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'estado' => 'Pendiente',
        ]);

        return redirect()->route('reservas.inicio')->with('success', '¡Tu solicitud de reserva ha sido enviada! Está pendiente de aprobación.');
    }

    /**
     * Muestra el historial de reservas del usuario.
     */
    public function misReservas()
    {
        $reservas = Auth::user()->reservas()->with('cancha')->orderBy('created_at', 'desc')->get();
        return view('reservas.mis-reservas', compact('reservas'));
    }

    /**
     * Muestra la vista del calendario general de reservas.
     */
    public function calendario()
    {
        $canchas = Cancha::where('estado', 'Disponible')->get();
        return view('reservas.calendario', compact('canchas'));
    }

    /**
     * API JSON: Devuelve las reservas aprobadas de una cancha para FullCalendar.
     */
    public function apiHorarios(Cancha $cancha)
    {
        $reservasAprobadas = Reserva::where('cancha_id', $cancha->id)
                                    ->where('estado', 'Aprobada')
                                    ->get();
        
        $eventos = [];
        foreach ($reservasAprobadas as $reserva) {
            $eventos[] = [
                'title' => $reserva->is_evento ? '🏅 ' . $reserva->titulo_evento : 'Ocupado',
                'start' => $reserva->fecha . 'T' . $reserva->hora_inicio,
                'end' => $reserva->fecha . 'T' . $reserva->hora_fin,
                'color' => $reserva->is_evento ? '#7c3aed' : '#dc2626', // bg-purple-600 vs bg-red-600
                'display' => 'block'
            ];
        }

        return response()->json($eventos);
    }
}
