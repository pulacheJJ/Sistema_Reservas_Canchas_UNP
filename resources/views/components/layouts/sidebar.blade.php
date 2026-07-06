{{-- Inyección de CSS específico del componente --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/layouts/sidebar.css') }}">
@endpush

<aside id="sidebar-principal" class="w-64 bg-blue-900 text-white flex flex-col shadow-xl flex-shrink-0 z-20 transition-all duration-300">
    <div class="p-6 border-b border-blue-800 flex items-center gap-3">
        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md p-1.5 flex-shrink-0">
            <img src="{{ asset('images/logo-unp.png') }}" alt="UNP" class="w-full h-full object-contain drop-shadow-sm">
        </div>
        <div>
            <h1 class="text-xl font-bold tracking-wide">Deportes</h1>
            <p class="text-[10px] text-blue-300 uppercase tracking-widest mt-0.5">Sistema Web</p>
        </div>
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

    <div class="p-4 border-t border-blue-800 bg-blue-950/50">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 border border-blue-400/30 flex items-center justify-center font-bold text-sm shadow-inner uppercase flex-shrink-0">
                    {{ $iniciales }}
                </div>
                <div class="overflow-hidden flex-1">
                    <p class="text-[13px] font-bold text-white truncate" title="{{ $usuario->name }}">{{ $usuario->name }}</p>
                    <p class="text-[10px] text-blue-300 truncate uppercase tracking-wider mt-0.5">
                        @if($usuario->isAdmin())
                            <span class="text-yellow-400 font-bold">Admin</span>
                        @else
                            Estudiante
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-0.5 flex-shrink-0">
                <!-- Campanita de notificaciones -->
                <div class="relative group">
                    <button class="text-blue-200 hover:text-white hover:bg-blue-800 transition-colors p-1.5 rounded-lg" title="Notificaciones">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if($usuario->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/4 bg-red-500 rounded-full shadow-sm border border-white">
                                {{ $usuario->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                    <!-- Dropdown de notificaciones -->
                    <div class="absolute bottom-0 left-full ml-4 w-64 bg-white rounded-lg shadow-2xl border border-gray-200 hidden group-hover:block z-50 overflow-hidden origin-bottom-left">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-3 py-2 text-[11px] font-bold text-white flex justify-between items-center">
                            <span>Notificaciones</span>
                            <span class="bg-white/20 px-1.5 py-0.5 rounded-full">{{ $usuario->unreadNotifications->count() }} nuevas</span>
                        </div>
                        <div class="max-h-48 overflow-y-auto">
                            @forelse($usuario->unreadNotifications as $notification)
                                <div class="px-3 py-2 border-b text-[12px] text-gray-800 hover:bg-blue-50 transition-colors border-l-4 border-blue-500 leading-tight">
                                    {{ $notification->data['mensaje'] }}
                                </div>
                            @empty
                                <div class="px-3 py-4 text-[11px] text-gray-500 text-center flex flex-col items-center gap-1">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    No hay notificaciones
                                </div>
                            @endforelse
                        </div>
                        @if($usuario->unreadNotifications->count() > 0)
                            <form action="{{ route('notificaciones.leer') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-center text-[11px] text-blue-600 font-bold py-2 hover:bg-blue-50 transition-colors bg-gray-50">
                                    Marcar todas como leídas
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Perfil -->
                <a href="{{ route('perfil.index') }}" class="text-blue-200 hover:text-white hover:bg-blue-800 transition-colors p-1.5 rounded-lg" title="Mi Perfil">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </a>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="mt-5 w-full">
            @csrf
            <button type="submit" id="btn-logout" class="w-full flex items-center justify-center gap-2 text-sm text-red-200 bg-red-500/10 hover:text-white hover:bg-red-500 transition-all duration-200 py-2.5 rounded-lg font-medium border border-red-500/20 hover:border-red-500 hover:shadow-lg">
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