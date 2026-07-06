<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CanchaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $canchas = [
            [
                'nombre' => 'Cancha Principal',
                'tipo' => 'Fútbol 11 (Césped Natural)',
                'ubicacion' => 'Campus UNP - Estadio',
                'estado' => 'Disponible',
                'imagen' => 'campus-unp.jpg'
            ],
            [
                'nombre' => 'Canchas Sintéticas',
                'tipo' => 'Futsal 7 / Futsal 5',
                'ubicacion' => 'Zona Deportiva',
                'estado' => 'Disponible',
                'imagen' => 'cancha-sintetica.png'
            ],
            [
                'nombre' => 'Coliseo UNP',
                'tipo' => 'Multiusos (Básquet/Futsal/Vóley)',
                'ubicacion' => 'Frente a Rectorado',
                'estado' => 'Mantenimiento',
                'imagen' => 'https://images.unsplash.com/photo-1504450758481-7338eba7524a?w=500'
            ],
            [
                'nombre' => 'Local Tangara',
                'tipo' => 'Espacios Múltiples',
                'ubicacion' => 'Sede Tangara (Externa)',
                'estado' => 'Disponible',
                'imagen' => 'tangarara.png'
            ],
        ];

        foreach ($canchas as $cancha) {
            \App\Models\Cancha::create($cancha);
        }
    }
}
