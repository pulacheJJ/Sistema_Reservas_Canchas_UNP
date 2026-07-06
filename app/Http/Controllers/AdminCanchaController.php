<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCanchaRequest;
use App\Models\Cancha;
use App\Services\CanchaService;

class AdminCanchaController extends Controller
{
    public function __construct(
        protected CanchaService $canchaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $canchas = $this->canchaService->obtenerTodas();
        return view('admin.canchas.index', compact('canchas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCanchaRequest $request)
    {
        $this->canchaService->crearCancha(
            $request->validated(), 
            $request->file('imagen')
        );

        return redirect()->route('admin.canchas.index')
            ->with('success', 'Instalación registrada correctamente.');
    }

    /**
     * Toggle the status of a specific facility (Disponible/Mantenimiento).
     */
    public function toggleEstado(Cancha $cancha)
    {
        $cancha = $this->canchaService->alternarEstado($cancha);
        return back()->with('success', 'Estado de la instalación actualizado a: ' . $cancha->estado);
    }
}
