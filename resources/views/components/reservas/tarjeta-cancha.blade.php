@props(['id', 'nombre', 'tipo', 'ubicacion', 'estado', 'imagen'])

@php
    $isDisponible = $estado === 'Disponible';
    $badgeClass = $isDisponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    $btnClass = $isDisponible ? 'bg-blue-800 hover:bg-blue-900 text-white btn-abrir-modal' : 'bg-gray-300 text-gray-500 cursor-not-allowed';
@endphp

<div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col border border-gray-200 transition-transform hover:-translate-y-1 hover:shadow-lg">
    <div class="h-48 w-full bg-gray-200 relative">
        <img src="{{ filter_var($imagen, FILTER_VALIDATE_URL) ? $imagen : asset('images/' . $imagen) }}" alt="{{ $nombre }}" class="w-full h-full object-cover">
        <div class="absolute top-3 right-3 px-2 py-1 rounded text-xs font-bold uppercase shadow-sm {{ $badgeClass }}">
            {{ $estado }}
        </div>
    </div>
    
    <div class="p-5 flex-1 flex flex-col">
        <h3 class="text-xl font-bold text-gray-800">{{ $nombre }}</h3>
        <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            {{ $ubicacion }}
        </p>
        <div class="mt-3">
            <span class="inline-block bg-blue-50 text-blue-800 border border-blue-100 text-xs px-2 py-1 rounded">
                {{ $tipo }}
            </span>
        </div>
        
        <div class="mt-auto pt-6">
            <button 
                class="w-full py-2.5 rounded-lg font-medium transition-colors shadow-sm {{ $btnClass }}" 
                data-id="{{ $id }}" 
                data-nombre="{{ $nombre }}"
                {{ !$isDisponible ? 'disabled' : '' }}>
                Reservar Horario
            </button>
        </div>
    </div>
</div>