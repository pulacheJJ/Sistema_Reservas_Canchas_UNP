<?php

namespace App\Http\Controllers;

use App\Services\ReporteService;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function __construct(
        protected ReporteService $reporteService
    ) {}

    /**
     * Muestra el dashboard de reportes del administrador.
     */
    public function index()
    {
        $kpis = $this->reporteService->obtenerKPIsGenerales();
        $estadoReservas = $this->reporteService->obtenerEstadoReservas();
        $usoCanchas = $this->reporteService->obtenerUsoPorCancha();

        // Preparar data para Chart.js
        $chartEstados = [
            'labels' => $estadoReservas->pluck('estado')->toArray(),
            'data' => $estadoReservas->pluck('total')->toArray(),
        ];

        $chartCanchas = [
            'labels' => $usoCanchas->pluck('nombre')->toArray(),
            'data' => $usoCanchas->pluck('reservas_count')->toArray(),
        ];

        return view('admin.reportes', compact('kpis', 'chartEstados', 'chartCanchas'));
    }
}
