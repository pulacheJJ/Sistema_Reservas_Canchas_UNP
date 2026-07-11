@extends('components.layouts.app')

@section('title', 'Panel de Administración | UNP')

@section('content')
    <div class="mb-10 pb-6 border-b border-slate-200">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard General</h2>
        <p class="text-slate-500 mt-2 font-medium">Bienvenido, {{ Auth::user()->name }}. Resumen rápido del estado del sistema.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8">
        
        <!-- Tarjeta Canchas -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 p-8 flex flex-col items-center text-center transform hover:-translate-y-1.5 transition-all duration-300 group">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Recintos Deportivos</h3>
            <p class="text-slate-500 text-sm mt-3 leading-relaxed mb-6 flex-1">
                Administra la disponibilidad, horarios de mantenimiento y características de todas las instalaciones.
            </p>
            <a href="{{ route('admin.canchas.index') }}" class="w-full py-3 bg-blue-50 text-blue-700 rounded-xl font-bold hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center gap-2">
                <span>Gestionar Recintos</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <!-- Tarjeta Reservas -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 p-8 flex flex-col items-center text-center transform hover:-translate-y-1.5 transition-all duration-300 group">
            <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-emerald-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Control de Reservas</h3>
            <p class="text-slate-500 text-sm mt-3 leading-relaxed mb-6 flex-1">
                Revisa solicitudes pendientes, aprueba horarios y cancela reservas problemáticas en tiempo real.
            </p>
            <a href="{{ route('admin.reservas.index') }}" class="w-full py-3 bg-emerald-50 text-emerald-700 rounded-xl font-bold hover:bg-emerald-600 hover:text-white transition-colors flex items-center justify-center gap-2">
                <span>Ir a Reservas</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <!-- Tarjeta Usuarios -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 p-8 flex flex-col items-center text-center transform hover:-translate-y-1.5 transition-all duration-300 group">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Usuarios del Sistema</h3>
            <p class="text-slate-500 text-sm mt-3 leading-relaxed mb-6 flex-1">
                Gestiona permisos, resetea contraseñas y administra los roles de estudiantes y docentes.
            </p>
            <a href="{{ route('admin.usuarios.index') }}" class="w-full py-3 bg-purple-50 text-purple-700 rounded-xl font-bold hover:bg-purple-600 hover:text-white transition-colors flex items-center justify-center gap-2">
                <span>Gestionar Usuarios</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <!-- Tarjeta Cierres Generales -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 p-8 flex flex-col items-center text-center transform hover:-translate-y-1.5 transition-all duration-300 group">
            <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-700 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-red-500/30 group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Cierres</h3>
            <p class="text-slate-500 text-sm mt-3 leading-relaxed mb-6 flex-1">
                Bloquea el acceso a todas las canchas por feriados, asambleas o cierres institucionales.
            </p>
            <button onclick="document.getElementById('modal-bloqueo').classList.remove('hidden')" class="w-full py-3 bg-red-50 text-red-700 rounded-xl font-bold hover:bg-red-600 hover:text-white transition-colors flex items-center justify-center gap-2">
                <span>Bloquear Sistema</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </button>
        </div>

    </div>

    <!-- Modal de Bloqueo General -->
    <div id="modal-bloqueo" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 transition-opacity p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 md:p-8 transform transition-all scale-95 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h3 class="text-2xl font-extrabold text-slate-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    Bloqueo de Universidad
                </h3>
                <button onclick="document.getElementById('modal-bloqueo').classList.add('hidden')" class="text-slate-400 hover:text-red-500 text-3xl leading-none">&times;</button>
            </div>
            
            <form action="{{ route('admin.evento.global') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="bg-red-50 p-4 rounded-xl text-sm text-red-800 border border-red-100 mb-6 font-medium">
                    ⚠️ Esta acción bloqueará TODAS las canchas simultáneamente en la fecha y horario que elijas. Las reservas existentes no se eliminarán, pero los estudiantes no podrán crear reservas nuevas.
                </div>

                <div>
                    <label for="fecha_bloqueo" class="block text-sm font-bold text-slate-700 mb-1">Fecha del Cierre</label>
                    <input type="date" id="fecha_bloqueo" name="fecha" required min="{{ date('Y-m-d') }}"
                        class="block w-full border-slate-300 rounded-xl shadow-sm focus:border-red-500 focus:ring-red-500 px-4 py-3 border text-slate-900 bg-slate-50">
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="hora_inicio_bloqueo" class="block text-sm font-bold text-slate-700 mb-1">Desde las</label>
                        <input type="time" id="hora_inicio_bloqueo" name="hora_inicio" required value="06:00"
                            class="block w-full border-slate-300 rounded-xl shadow-sm focus:border-red-500 focus:ring-red-500 px-4 py-3 border text-slate-900 bg-slate-50">
                    </div>
                    <div>
                        <label for="hora_fin_bloqueo" class="block text-sm font-bold text-slate-700 mb-1">Hasta las</label>
                        <input type="time" id="hora_fin_bloqueo" name="hora_fin" required value="23:00"
                            class="block w-full border-slate-300 rounded-xl shadow-sm focus:border-red-500 focus:ring-red-500 px-4 py-3 border text-slate-900 bg-slate-50">
                    </div>
                </div>

                <div>
                    <label for="titulo_evento" class="block text-sm font-bold text-slate-700 mb-1">Motivo (Visible para todos)</label>
                    <input type="text" id="titulo_evento" name="titulo_evento" required placeholder="Ej: Feriado, Huelga, Asueto..."
                        class="block w-full border-slate-300 rounded-xl shadow-sm focus:border-red-500 focus:ring-red-500 px-4 py-3 border text-slate-900 bg-slate-50">
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="document.getElementById('modal-bloqueo').classList.add('hidden')" class="flex-1 bg-white border border-slate-300 text-slate-700 py-3 rounded-xl hover:bg-slate-50 transition-colors font-bold shadow-sm">Cancelar</button>
                    <button type="submit" class="flex-1 bg-red-600 text-white py-3 rounded-xl hover:bg-red-700 transition-colors shadow-lg shadow-red-500/30 font-bold flex justify-center items-center gap-2">
                        <span>Aplicar Bloqueo</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
