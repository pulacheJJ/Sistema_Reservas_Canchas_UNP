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

        \App\Models\User::create([
            'name' => 'Estudiante Prueba',
            'codigo' => '2023123456',
            'role' => 'estudiante',
            'password' => bcrypt('87654321'),
        ]);

        $this->call([
            CanchaSeeder::class,
        ]);
    }
}
