@extends('components.layouts.app')

@section('title', 'Mi Perfil | UNP')

@section('content')
    <div class="mb-6 sm:mb-10 pb-4 sm:pb-6 border-b border-slate-200">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Mi Perfil</h2>
        <p class="text-slate-500 mt-2 font-medium">Gestiona tu información personal y credenciales de acceso al sistema.</p>
    </div>

    <!-- Alertas Modernas -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50/80 backdrop-blur border border-emerald-200 text-emerald-700 px-4 sm:px-6 py-4 rounded-xl flex items-start gap-3 shadow-sm transform transition-all" role="alert">
            <svg class="w-6 h-6 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline font-medium text-sm mt-0.5">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-5 sm:gap-8">
        
        <!-- Panel Izquierdo: Tarjeta de Resumen -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                <div class="h-32 bg-gradient-to-r from-blue-600 to-blue-800"></div>
                <div class="px-8 pb-8 flex flex-col items-center -mt-16">
                    <!-- Avatar grande -->
                    <div class="w-32 h-32 bg-white rounded-full p-2 shadow-lg mb-4">
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center text-4xl font-extrabold text-blue-700">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 text-center">{{ $user->name }}</h3>
                    <p class="text-sm font-medium text-slate-500 mb-4">{{ $user->email ?? 'Sin correo registrado' }}</p>
                    
                    <div class="w-full pt-4 border-t border-slate-100 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Código</span>
                            <span class="text-sm font-bold text-slate-800 bg-slate-100 px-2 py-1 rounded">{{ $user->codigo }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rol en Sistema</span>
                            <span class="text-sm font-bold {{ $user->isAdmin() ? 'text-purple-700 bg-purple-100' : 'text-blue-700 bg-blue-100' }} px-2 py-1 rounded">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Miembro desde</span>
                            <span class="text-sm font-medium text-slate-700">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Derecho: Formulario de Actualización -->
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-4 sm:p-6 md:p-10">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Ajustes de la Cuenta
                </h3>
                
                <form action="{{ route('perfil.update') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nombre Completo</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefono" class="block text-sm font-bold text-slate-700 mb-1">Número de WhatsApp (Opcional)</label>
                            <input type="tel" name="telefono" id="telefono" value="{{ old('telefono', $user->telefono) }}" class="mt-1 block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors" placeholder="+51 987 654 321">
                            <p class="text-xs text-slate-500 mt-1">Este número se utilizará para enviarte los comprobantes de tus reservas automáticamente.</p>
                            @error('telefono')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <h4 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider">Seguridad</h4>
                            <p class="text-xs text-slate-500 mb-4">Deja los campos de contraseña en blanco si no deseas cambiarla.</p>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-bold text-slate-700 mb-1">Contraseña Actual</label>
                                    <input type="password" name="current_password" id="current_password" class="mt-1 block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors" placeholder="••••••••">
                                    @error('current_password')
                                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="password" class="block text-sm font-bold text-slate-700 mb-1">Nueva Contraseña</label>
                                        <input type="password" name="password" id="password" class="mt-1 block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors" placeholder="••••••••">
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1">Confirmar Nueva Contraseña</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors" placeholder="••••••••">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-stretch sm:justify-end">
                        <button type="submit" class="w-full sm:w-auto justify-center px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-500/50 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                            Guardar Cambios
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
