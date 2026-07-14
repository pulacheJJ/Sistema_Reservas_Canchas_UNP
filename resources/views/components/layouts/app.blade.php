<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reservas UNP')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body x-data="{ sidebarOpen: false }" class="bg-slate-50 font-sans flex h-screen overflow-hidden selection:bg-blue-100 selection:text-blue-900">

    <!-- Mobile sidebar backdrop -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm md:hidden" style="display: none;" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    @include('components.layouts.sidebar')

    <main class="flex-1 flex flex-col overflow-hidden relative">
        
        <!-- Header Moderno -->
        <header class="bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-200 px-6 py-4 flex justify-between items-center z-20 sticky top-0">
            <div class="flex items-center gap-4">
                <!-- Botón Menú Móvil (Visible solo en pantallas pequeñas) -->
                <button @click="sidebarOpen = true" class="md:hidden text-slate-500 hover:text-slate-700 focus:outline-none p-1 border border-slate-200 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight hidden sm:block">Plataforma de Reservas UNP</h2>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Estado Sede -->
                <div class="hidden md:flex items-center gap-2 bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-100">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Campus Piura</span>
                </div>

                <!-- Menú Usuario Dropdown (AlpineJS) -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 hover:bg-slate-50 p-1.5 rounded-xl transition-colors">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs font-medium text-slate-500">{{ Auth::user()->role === 'admin' ? 'Administrador' : 'Estudiante/Docente' }}</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- Dropdown Content -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 border border-slate-100 z-50" style="display: none;">
                        <a href="{{ route('perfil.index') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 font-medium transition-colors">Mi Perfil</a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenedor Principal (Vistas) -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-slate-50/50">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>

    @stack('scripts')
</body>
</html>