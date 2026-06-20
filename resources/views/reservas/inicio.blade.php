@extends('components.layouts.app')

@section('title', 'Instalaciones | UNP')

@section('content')
    <div class="mb-8 border-b pb-4">
        <h2 class="text-3xl font-bold text-gray-800">Recintos Deportivos</h2>
        <p class="text-gray-600 mt-2">Selecciona la instalación para tu partido.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        @include('components.reservas.tarjeta-cancha', [
            'id' => 1,
            'nombre' => 'Cancha Principal',
            'tipo' => 'Fútbol 11 (Césped Natural)',
            'ubicacion' => 'Campus UNP - Estadio',
            'estado' => 'Disponible',
            'imagen' => 'https://images.unsplash.com/photo-1518605368461-1e122b515513?w=500'
        ])

        @include('components.reservas.tarjeta-cancha', [
            'id' => 2,
            'nombre' => 'Canchas Sintéticas',
            'tipo' => 'Futsal 7 / Futsal 5',
            'ubicacion' => 'Zona Deportiva',
            'estado' => 'Disponible',
            'imagen' => 'https://images.unsplash.com/photo-1551280857-226871a39626?w=500'
        ])

        @include('components.reservas.tarjeta-cancha', [
            'id' => 3,
            'nombre' => 'Coliseo UNP',
            'tipo' => 'Multiusos (Básquet/Futsal/Vóley)',
            'ubicacion' => 'Frente a Rectorado',
            'estado' => 'Mantenimiento',
            'imagen' => 'https://images.unsplash.com/photo-1504450758481-7338eba7524a?w=500'
        ])

        @include('components.reservas.tarjeta-cancha', [
            'id' => 4,
            'nombre' => 'Local Tangara',
            'tipo' => 'Espacios Múltiples',
            'ubicacion' => 'Sede Tangara (Externa)',
            'estado' => 'Disponible',
            'imagen' => 'https://images.unsplash.com/photo-1526232761682-d26e03ac148e?w=500'
        ])

    </div>

    @include('components.reservas.modal-reserva')
@endsection

@push('scripts')
    <script src="{{ asset('js/reservas/inicio.js') }}"></script>
@endpush