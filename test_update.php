<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $cancha = \App\Models\Cancha::first();
    if (!$cancha) {
        $cancha = \App\Models\Cancha::create([
            'nombre' => 'Local Tangara 1',
            'tipo' => 'Espacios Múltiples',
            'ubicacion' => 'Sede Tangara (Externa)',
            'estado' => 'Disponible',
            'descripcion' => '',
            'capacidad' => 10,
            'imagen' => 'tangarara.png',
        ]);
    }
    
    // Simulate update
    $cancha->update([
        'nombre' => 'Local Tangara 1',
        'tipo' => 'Espacios Múltiples',
        'ubicacion' => 'Sede Tangara (Externa)',
        'capacidad' => 10,
        'descripcion' => '',
        'imagen' => 'tangarara.png'
    ]);
    
    echo "Update successful.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
