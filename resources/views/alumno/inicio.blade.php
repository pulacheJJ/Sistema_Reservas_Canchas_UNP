@extends('components.layouts.app')

@section('title', 'Instalaciones | UNP')

@push('styles')
    <!-- FullCalendar CSS CDN -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
@endpush

@section('content')
    <!-- Alertas Modernas -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50/80 backdrop-blur border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-start gap-3 shadow-sm transform transition-all" role="alert">
            <svg class="w-6 h-6 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline font-medium text-sm mt-0.5">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="mb-6 bg-red-50/80 backdrop-blur border border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-start gap-3 shadow-sm transform transition-all" role="alert">
            <svg class="w-6 h-6 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="mt-0.5">
                @if(session('error'))
                    <span class="block font-medium text-sm">{{ session('error') }}</span>
                @endif
                @if($errors->any())
                    <ul class="list-disc pl-4 text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endif

    <div class="mb-10 pb-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Canchas Disponibles</h2>
            <p class="text-slate-500 mt-2 font-medium">Selecciona la instalación y el horario que deseas utilizar para tu reserva.</p>
        </div>
    </div>

    @if($canchasAgrupadas->isNotEmpty())
        <div x-data="{ tab: '{{ array_key_first($canchasAgrupadas->toArray()) }}' }">
            
            <!-- Navegación de Pestañas (Pills) -->
            <div class="flex mb-8 space-x-3 overflow-x-auto no-scrollbar pb-2">
                @foreach($canchasAgrupadas as $ubicacion => $canchas)
                    <button @click="tab = '{{ $ubicacion }}'" 
                            :class="tab === '{{ $ubicacion }}' ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 hover:text-slate-900 border border-slate-200'"
                            class="whitespace-nowrap px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300">
                        {{ $ubicacion }}
                    </button>
                @endforeach
            </div>

            <!-- Contenido de las Pestañas -->
            <div class="relative min-h-[400px]">
                @foreach($canchasAgrupadas as $ubicacion => $canchas)
                    <div x-show="tab === '{{ $ubicacion }}'" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-y-4" 
                         x-transition:enter-end="opacity-100 transform translate-y-0" 
                         class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8" 
                         style="display: none;">
                        @foreach($canchas as $cancha)
                            @include('components.shared.tarjeta-cancha', [
                                'id' => $cancha->id,
                                'nombre' => $cancha->nombre,
                                'tipo' => $cancha->tipo,
                                'descripcion' => $cancha->descripcion,
                                'ubicacion' => $cancha->ubicacion,
                                'estado' => $cancha->estado,
                                'imagen' => $cancha->imagen
                            ])
                        @endforeach
                    </div>
                @endforeach
            </div>

        </div>
    @else
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 shadow-sm">
            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">No hay instalaciones registradas</h3>
            <p class="text-slate-500">Actualmente no existen canchas disponibles en el sistema.</p>
        </div>
    @endif

    @include('components.shared.modal-reserva')
@endsection

@push('scripts')
    <!-- FullCalendar JS CDN -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>
    
    <script src="{{ asset('js/reservas/inicio.js') }}"></script>
@endpush