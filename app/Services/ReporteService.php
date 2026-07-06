<?php

namespace App\Services;

use App\Models\Cancha;
use App\Models\Reserva;
use App\Models\Sancion;
use Illuminate\Support\Facades\DB;

class ReporteService
{
    /**
     * Obtiene los KPIs generales del sistema.
     */
    public function obtenerKPIsGenerales()
    {
        return [
            'total_reservas' => Reserva::count(),
            'reservas_aprobadas' => Reserva::where('estado', 'Aprobada')->count(),
            'canchas_disponibles' => Cancha::where('estado', 'Disponible')->count(),
            'alumnos_sancionados' => Sancion::where('fecha_fin', '>=', now())->distinct('user_id')->count(),
        ];
    }

    /**
     * Obtiene la cantidad de reservas agrupadas por estado para el gráfico de Dona.
     */
    public function obtenerEstadoReservas()
    {
        return Reserva::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();
    }

    /**
     * Obtiene el ranking de las canchas más reservadas (Top 5).
     */
    public function obtenerUsoPorCancha()
    {
        return Cancha::withCount('reservas')
            ->orderBy('reservas_count', 'desc')
            ->take(5)
            ->get();
    }
}
