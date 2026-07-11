{{-- Inyección de CSS específico del componente --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/layouts/sidebar.css') }}">
@endpush

<aside id="sidebar-principal" class="w-64 bg-blue-900 text-white flex flex-col shadow-xl flex-shrink-0 z-40 transition-transform duration-300 fixed md:relative h-full transform" :class="{'translate-x-0': sidebarOpen, '-translate-x-full md:translate-x-0': !sidebarOpen}">
    <div class="p-6 border-b border-blue-800 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md p-1.5 flex-shrink-0">
                <img src="{{ asset('images/logo-unp.png') }}" alt="UNP" class="w-full h-full object-contain drop-shadow-sm">
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-wide">Deportes</h1>
                <p class="text-[10px] text-blue-300 uppercase tracking-widest mt-0.5">Sistema Web</p>
            </div>
        </div>
        <button @click="sidebarOpen = false" class="md:hidden text-blue-300 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    @php
        $usuario = Auth::user();
        // Obtener iniciales: primer caracter del nombre
        $iniciales = strtoupper(substr($usuario->name, 0, 2));
    @endphp

    <nav class="sidebar-nav flex-1 p-4 space-y-2 overflow-y-auto">
        
        <div class="text-xs font-semibold text-blue-400 uppercase tracking-wider mb-3 mt-2 px-2">Portal Estudiantil</div>
        
        <a href="{{ route('reservas.calendario') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border border-transparent hover:bg-blue-800 {{ request()->routeIs('reservas.calendario') ? 'bg-blue-800 border-blue-700 font-medium' : 'text-blue-100' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('reservas.calendario') ? 'text-blue-200' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Calendario
        </a>

        <a href="{{ route('reservas.inicio') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium border border-transparent hover:bg-blue-800 {{ request()->routeIs('reservas.inicio') ? 'bg-blue-800 border-blue-700' : 'text-blue-100' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('reservas.inicio') ? 'text-blue-200' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Hacer Reserva
        </a>
        
        <a href="{{ route('reservas.mis-reservas') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border border-transparent hover:bg-blue-800 {{ request()->routeIs('reservas.mis-reservas') ? 'bg-blue-800 border-blue-700 font-medium' : 'text-blue-100' }}">
            <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Mis Reservas
        </a>

        @if($usuario->isAdmin())
            <div class="text-xs font-semibold text-yellow-500 uppercase tracking-wider mb-3 mt-8 px-2 border-t border-blue-800 pt-4">Administración</div>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border border-transparent hover:bg-blue-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 border-blue-700 font-medium' : 'text-blue-100' }}">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            
            <a href="{{ route('admin.canchas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border border-transparent hover:bg-blue-800 {{ request()->routeIs('admin.canchas.*') ? 'bg-blue-800 border-blue-700 font-medium' : 'text-blue-100' }}">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Gestión de Canchas
            </a>

            <a href="{{ route('admin.reportes') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border border-transparent hover:bg-blue-800 {{ request()->routeIs('admin.reportes') ? 'bg-blue-800 border-blue-700 font-medium' : 'text-blue-100' }}">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Reportes y Estadísticas
            </a>

            <a href="{{ route('admin.reservas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border border-transparent hover:bg-blue-800 {{ request()->routeIs('admin.reservas.*') ? 'bg-blue-800 border-blue-700 font-medium' : 'text-blue-100' }}">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Control de Reservas
            </a>
            
            <a href="{{ route('admin.usuarios.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border border-transparent hover:bg-blue-800 {{ request()->routeIs('admin.usuarios.*') ? 'bg-blue-800 border-blue-700 font-medium' : 'text-blue-100' }}">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Gestión de Usuarios
            </a>
        @endif
    </nav>
</aside>

{{-- Inyección de JS específico del componente --}}
@push('scripts')
    <script src="{{ asset('js/layouts/sidebar.js') }}"></script>
@endpush