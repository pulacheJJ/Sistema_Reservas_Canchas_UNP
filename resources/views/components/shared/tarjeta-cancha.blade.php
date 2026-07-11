@props(['id', 'nombre', 'tipo', 'descripcion', 'ubicacion', 'estado', 'imagen'])

@php
    $isDisponible = $estado === 'Disponible';
    $badgeClass = $isDisponible ? 'bg-emerald-500/90 text-white border border-emerald-400' : 'bg-red-500/90 text-white border border-red-400';
    $btnClass = $isDisponible ? 'bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white shadow-blue-500/30 btn-abrir-modal' : 'bg-slate-200 text-slate-500 cursor-not-allowed';
@endphp

<div class="bg-white rounded-2xl shadow-sm hover:shadow-xl overflow-hidden flex flex-col border border-slate-100 transition-all duration-300 transform hover:-translate-y-2 group">
    <!-- Image Header -->
    <div class="h-52 w-full bg-slate-200 relative overflow-hidden">
        <img src="{{ filter_var($imagen, FILTER_VALIDATE_URL) ? $imagen : asset('images/' . $imagen) }}" alt="{{ $nombre }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out">
        
        <!-- Overlay Gradient for better text readability if needed -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

        <!-- Modern Badge -->
        <div class="absolute top-4 right-4 px-3 py-1.5 rounded-full text-[10px] tracking-wider font-bold uppercase shadow-sm backdrop-blur-md {{ $badgeClass }}">
            {{ $estado }}
        </div>
    </div>
    
    <!-- Content Body -->
    <div class="p-6 flex-1 flex flex-col relative bg-white">
        <!-- Floating Tipo Badge -->
        <div class="absolute -top-4 left-6">
            <span class="inline-block bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                {{ $tipo }}
            </span>
        </div>

        <h3 class="text-xl font-bold text-slate-800 mt-2">{{ $nombre }}</h3>
        
        <p class="text-sm text-slate-500 mt-1 flex items-center gap-1.5 font-medium">
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            {{ $ubicacion }}
        </p>
        
        @if(!empty($descripcion))
            <p class="text-sm text-slate-600 mt-4 line-clamp-2 leading-relaxed" title="{{ $descripcion }}">
                {{ $descripcion }}
            </p>
        @endif
        
        <!-- Call to Action -->
        <div class="mt-auto pt-6">
            <button 
                class="w-full py-3 rounded-xl font-bold transition-all duration-300 shadow-md {{ $btnClass }}" 
                data-id="{{ $id }}" 
                data-nombre="{{ $nombre }}"
                {{ !$isDisponible ? 'disabled' : '' }}>
                @if($isDisponible)
                    <span class="flex items-center justify-center gap-2">
                        Reservar Horario
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                @else
                    No Disponible
                @endif
            </button>
        </div>
    </div>
</div>