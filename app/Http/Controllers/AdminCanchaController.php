<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cancha;

class AdminCanchaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $canchas = Cancha::orderBy('created_at', 'desc')->get();
        return view('admin.canchas.index', compact('canchas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'imagen' => 'required|url',
        ]);

        Cancha::create([
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'ubicacion' => $request->ubicacion,
            'imagen' => $request->imagen,
            'estado' => 'Disponible',
        ]);

        return back()->with('success', 'Nueva cancha agregada exitosamente.');
    }

    /**
     * Toggle the status of a specific facility (Disponible/Mantenimiento).
     */
    public function toggleEstado(Cancha $cancha)
    {
        $nuevoEstado = $cancha->estado === 'Disponible' ? 'Mantenimiento' : 'Disponible';
        
        $cancha->update([
            'estado' => $nuevoEstado
        ]);

        return back()->with('success', 'Estado de la instalación actualizado a: ' . $nuevoEstado);
    }
}
