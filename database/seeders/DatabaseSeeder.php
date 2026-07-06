<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Administrador UNP',
            'codigo' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        // Se elimina el estudiante de prueba para producción
        $this->call([
            CanchaSeeder::class,
        ]);
    }
}
