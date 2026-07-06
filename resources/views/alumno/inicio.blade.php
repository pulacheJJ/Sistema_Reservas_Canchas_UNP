@extends('components.layouts.app')

@section('title', 'Instalaciones | UNP')

@push('styles')
    <!-- FullCalendar CSS CDN -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
@endpush

@section('content')
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-8 border-b pb-4">
        <h2 class="text-3xl font-bold text-gray-800">Canchas Disponibles</h2>
        <p class="text-gray-600 mt-2">Selecciona la instalación y el horario que deseas utilizar para tu reserva.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        @foreach($canchas as $cancha)
            @include('components.shared.tarjeta-cancha', [
                'id' => $cancha->id,
                'nombre' => $cancha->nombre,
                'tipo' => $cancha->tipo,
                'ubicacion' => $cancha->ubicacion,
                'estado' => $cancha->estado,
                'imagen' => $cancha->imagen
            ])
        @endforeach

    </div>

    @include('components.shared.modal-reserva')
@endsection

@push('scripts')
    <!-- FullCalendar JS CDN -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>
    
    <script src="{{ asset('js/reservas/inicio.js') }}"></script>
@endpush