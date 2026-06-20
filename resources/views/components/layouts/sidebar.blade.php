{{-- Inyección de CSS específico del componente --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/layouts/sidebar.css') }}">
@endpush

<aside id="sidebar-principal" class="w-64 bg-blue-900 text-white flex flex-col shadow-xl flex-shrink-0 z-20 transition-all duration-300">
    <div class="p-6 border-b border-blue-800 flex items-center gap-3">
        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-900 font-bold">UNP</div>
        <div>
            <h1 class="text-xl font-bold tracking-wide">Deportes</h1>
            <p class="text-[10px] text-blue-300 uppercase tracking-widest mt-0.5">Sistema Web</p>
        </div>
    </div>

    @php
        $usuarioActivo = (object) [
            'nombre' => 'Jaime Pulache',
            'iniciales' => 'JP',
            'escuela' => 'Ingeniería Informática',
            'perfil' => '9no Ciclo',
            'rol' => 'admin' 
        ];
    @endphp

    <nav class="sidebar-nav flex-1 p-4 space-y-2 overflow-y-auto">
        
        <div class="text-xs font-semibold text-blue-400 uppercase tracking-wider mb-3 mt-2 px-2">Portal Estudiantil</div>
        
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium border bg-blue-800 border-blue-700 active-nav-item">
            <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Módulo Reserva
        </a>
        
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-blue-100 border border-transparent hover:bg-blue-800">
            <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Mis Reservas
        </a>

        @if($usuarioActivo->rol === 'admin')
            <div class="text-xs font-semibold text-yellow-500 uppercase tracking-wider mb-3 mt-8 px-2 border-t border-blue-800 pt-4">Administración</div>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-blue-100 border border-transparent hover:bg-blue-800">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Gestión de Canchas
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-blue-100 border border-transparent hover:bg-blue-800">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Control de Reservas
            </a>
        @endif
    </nav>

    <div class="p-4 border-t border-blue-800 bg-blue-900/50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-700 border border-blue-600 flex items-center justify-center font-bold text-sm shadow-inner uppercase">
                {{ $usuarioActivo->iniciales }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-semibold truncate">{{ $usuarioActivo->nombre }}</p>
                <p class="text-xs text-blue-300 truncate">
                    @if($usuarioActivo->rol === 'admin')
                        <span class="text-yellow-400 font-bold">Administrador</span>
                    @else
                        {{ $usuarioActivo->perfil }}
                    @endif
                </p>
            </div>
        </div>
        
        <form id="form-logout" method="POST" action="{{-- route('logout') --}}" class="mt-4 w-full">
            <button type="submit" id="btn-logout" class="w-full flex items-center justify-center gap-2 text-sm text-red-300 hover:text-white hover:bg-red-600 transition-colors py-2 border border-red-900/50 rounded-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside>

{{-- Inyección de JS específico del componente --}}
@push('scripts')
    <script src="{{ asset('js/layouts/sidebar.js') }}"></script>
@endpush