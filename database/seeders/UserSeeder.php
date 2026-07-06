<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Administrador Principal
        User::updateOrCreate(
            ['codigo' => 'admin'],
            [
                'name' => 'Administrador UNP',
                'email' => 'admin@unp.edu.pe',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Crear Estudiante de Prueba 1
        User::updateOrCreate(
            ['codigo' => '0512022099'],
            [
                'name' => 'Juan Jimenez',
                'email' => '0512022099@alumnos.unp.edu.pe',
                'role' => 'estudiante',
                'password' => Hash::make('unp123456'),
            ]
        );

        // 3. Crear Estudiante de Prueba 2
        User::updateOrCreate(
            ['codigo' => '0512022089'],
            [
                'name' => 'Julio Garcia',
                'email' => '0512022089@alumnos.unp.edu.pe',
                'role' => 'estudiante',
                'password' => Hash::make('unp123456'),
            ]
        );
        
        // 4. Crear Administrador Secundario
        User::updateOrCreate(
            ['codigo' => 'admin2'],
            [
                'name' => 'Soporte Deportes',
                'email' => 'soporte.deportes@unp.edu.pe',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}
