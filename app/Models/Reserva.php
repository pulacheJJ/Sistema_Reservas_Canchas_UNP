<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cancha_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
        'is_evento',
        'titulo_evento'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }
}
