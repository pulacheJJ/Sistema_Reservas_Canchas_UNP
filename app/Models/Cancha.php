<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'descripcion',
        'capacidad',
        'ubicacion',
        'estado',
        'imagen',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
