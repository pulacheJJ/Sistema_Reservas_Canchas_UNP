<?php

namespace App\Services;

use App\Models\Cancha;
use Illuminate\Http\UploadedFile;

class CanchaService
{
    /**
     * Devuelve todas las canchas.
     */
    public function obtenerTodas()
    {
        return Cancha::all();
    }

    /**
     * Devuelve las canchas disponibles.
     */
    public function obtenerDisponibles()
    {
        return Cancha::where('estado', 'Disponible')->get();
    }

    /**
     * Crea una nueva cancha y guarda su imagen.
     */
    public function crearCancha(array $data, ?UploadedFile $imagen = null)
    {
        $nombreImagen = $data['imagen'] ?? 'default-cancha.jpg';

        if ($imagen) {
            $nombreImagen = time() . '.' . $imagen->extension();
            $imagen->move(public_path('images'), $nombreImagen);
        }

        return Cancha::create([
            'nombre' => $data['nombre'],
            'tipo' => $data['tipo'],
            'ubicacion' => $data['ubicacion'],
            'estado' => $data['estado'] ?? 'Disponible',
            'descripcion' => $data['descripcion'] ?? null,
            'capacidad' => $data['capacidad'] ?? 10,
            'imagen' => $nombreImagen,
        ]);
    }

    /**
     * Alterna el estado de una cancha entre Disponible y En Mantenimiento.
     */
    public function alternarEstado(Cancha $cancha)
    {
        $nuevoEstado = $cancha->estado === 'Disponible' ? 'Mantenimiento' : 'Disponible';
        $cancha->update(['estado' => $nuevoEstado]);
        
        return $cancha;
    }
}
