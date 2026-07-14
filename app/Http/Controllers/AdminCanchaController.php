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
        $canchasAgrupadas = Cancha::all()->groupBy('ubicacion');
        return view('admin.canchas.index', compact('canchasAgrupadas'));
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

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCanchaRequest $request, Cancha $cancha)
    {
        $data = $request->validated();
        
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            if (env('CLOUDINARY_URL')) {
                $data['imagen'] = $imagen->storeOnCloudinary('canchas_unp')->getSecurePath();
            } else {
                $nombreImagen = time() . '.' . $imagen->extension();
                $imagen->move(public_path('images'), $nombreImagen);
                $data['imagen'] = $nombreImagen;
            }
        }

        $cancha->update($data);

        return redirect()->route('admin.canchas.index')
            ->with('success', 'Instalación actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cancha $cancha)
    {
        // Verificar si tiene reservas antes de eliminar (opcional, por ahora lo forzamos)
        $cancha->delete();

        return redirect()->route('admin.canchas.index')
            ->with('success', 'Instalación eliminada correctamente.');
    }
}
