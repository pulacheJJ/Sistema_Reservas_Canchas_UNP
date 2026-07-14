<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Reservas Deportivas UNP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen flex bg-slate-50">
    
    <!-- LADO IZQUIERDO: Imagen premium (Oculto en móvil) -->
    <div class="hidden lg:flex lg:w-5/12 relative bg-left-panel">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/90 via-blue-900/70 to-blue-800/90 z-0 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-blue-600/20 z-0"></div>
        
        <div class="relative z-10 flex flex-col justify-between p-12 w-full h-full text-white">
            <div class="flex items-center gap-3">
                <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center shadow-lg p-1">
                    <img src="{{ asset('images/logo-unp.png') }}" alt="UNP" class="w-full h-full object-contain drop-shadow-md">
                </div>
                <span class="font-bold text-2xl tracking-widest uppercase opacity-90">Deportes</span>
            </div>

            <div class="mb-10">
                <h1 class="text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mb-6">
                    Únete a la<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-emerald-300">comunidad deportiva.</span>
                </h1>
                <p class="text-lg text-blue-100 max-w-sm font-light leading-relaxed">
                    Registra tu cuenta institucional y comienza a reservar las instalaciones deportivas de la universidad.
                </p>
            </div>

            <div class="flex items-center gap-4 text-sm text-blue-200/80 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Campus Universitario, Piura, Perú</span>
            </div>
        </div>
    </div>

    <!-- LADO DERECHO: Formulario Blanco Limpio -->
    <div class="w-full lg:w-7/12 flex flex-col justify-center items-center px-6 sm:px-12 md:px-24 relative bg-white overflow-y-auto py-12">
        
        <div class="w-full max-w-md">
            
            <div class="lg:hidden flex items-center gap-3 mb-10">
                <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center shadow-lg p-1">
                    <img src="{{ asset('images/logo-unp.png') }}" alt="UNP" class="w-full h-full object-contain drop-shadow-md">
                </div>
                <span class="font-bold text-2xl tracking-widest uppercase text-slate-800">Deportes</span>
            </div>

            <div class="mb-10 text-center lg:text-left">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-3 tracking-tight">Crear una cuenta</h2>
                <p class="text-slate-500 font-medium mb-1">Ingresa tus datos para registrarte en el sistema.</p>
            </div>

            <form method="POST" action="{{ route('register.post') }}" class="space-y-6" x-data="{ password: '', password_confirmation: '', selectedRole: 'estudiante' }">
                @csrf

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-sm mb-6" role="alert">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <h3 class="text-sm font-bold text-red-800">Se encontraron errores:</h3>
                                <ul class="mt-1 text-sm text-red-700 list-disc list-inside font-medium">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="space-y-5">
                    <!-- Selector de Rol (Tarjetas Premium) -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-3">¿A qué grupo perteneces?</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="estudiante" x-model="selectedRole" class="peer sr-only">
                                <div class="rounded-xl border-2 border-slate-100 bg-slate-50 p-2 text-center hover:bg-slate-100 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-800 transition-all flex flex-col items-center justify-center gap-1 shadow-sm h-full">
                                    <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                    <span class="block text-xs font-bold leading-tight">Estudiante</span>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="docente" x-model="selectedRole" class="peer sr-only">
                                <div class="rounded-xl border-2 border-slate-100 bg-slate-50 p-2 text-center hover:bg-slate-100 peer-checked:border-purple-600 peer-checked:bg-purple-50 peer-checked:text-purple-800 transition-all flex flex-col items-center justify-center gap-1 shadow-sm h-full">
                                    <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="block text-xs font-bold leading-tight">Docente</span>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="administrativo" x-model="selectedRole" class="peer sr-only">
                                <div class="rounded-xl border-2 border-slate-100 bg-slate-50 p-2 text-center hover:bg-slate-100 peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-800 transition-all flex flex-col items-center justify-center gap-1 shadow-sm h-full">
                                    <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <span class="block text-xs font-bold leading-tight">Administrativo</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Campo Codigo -->
                    <div class="relative">
                        <input type="text" id="codigo" name="codigo" required autofocus placeholder=" "
                            class="input-floating block w-full px-4 pt-6 pb-2 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none"
                            value="{{ old('codigo') }}">
                        <label for="codigo" class="absolute left-4 top-4 text-slate-400 text-sm transition-all pointer-events-none font-medium">
                            Código / DNI
                        </label>
                    </div>

                    <!-- Campo Nombre -->
                    <div class="relative">
                        <input type="text" id="name" name="name" required placeholder=" "
                            class="input-floating block w-full px-4 pt-6 pb-2 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none"
                            value="{{ old('name') }}">
                        <label for="name" class="absolute left-4 top-4 text-slate-400 text-sm transition-all pointer-events-none font-medium">
                            Nombre y Apellidos
                        </label>
                    </div>

                    <!-- Campo Email -->
                    <div class="relative">
                        <input type="email" id="email" name="email" required placeholder=" "
                            class="input-floating block w-full px-4 pt-6 pb-2 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none"
                            value="{{ old('email') }}">
                        <label for="email" class="absolute left-4 top-4 text-slate-400 text-sm transition-all pointer-events-none font-medium">
                            Correo Institucional
                        </label>
                        <!-- Mensaje dinámico de correo según rol -->
                        <div class="mt-1 pl-2 flex items-center gap-1 transition-all">
                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span x-show="selectedRole === 'estudiante'" class="text-[11px] font-semibold text-blue-600">Debe terminar en @alumnos.unp.edu.pe</span>
                            <span x-show="selectedRole === 'docente'" class="text-[11px] font-semibold text-purple-600" style="display: none;">Debe terminar en @unpdocente.edu.pe</span>
                            <span x-show="selectedRole === 'administrativo'" class="text-[11px] font-semibold text-orange-600" style="display: none;">Debe terminar en @unp.edu.pe</span>
                        </div>
                    </div>

                    <!-- Campo Teléfono -->
                    <div class="relative">
                        <input type="tel" id="telefono" name="telefono" placeholder=" "
                            class="input-floating block w-full px-4 pt-6 pb-2 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none"
                            value="{{ old('telefono') }}">
                        <label for="telefono" class="absolute left-4 top-4 text-slate-400 text-sm transition-all pointer-events-none font-medium">
                            Número de WhatsApp (Opcional)
                        </label>
                        <p class="text-[10px] text-slate-400 mt-1 pl-2">Necesario para recibir los comprobantes de reserva.</p>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="relative">
                        <div class="flex justify-between items-end mb-1 px-1">
                            <span class="text-xs font-semibold text-slate-500">Mínimo 8 caracteres</span>
                            <span x-show="password.length > 0 && password.length < 8" x-transition class="text-xs font-bold text-red-500">Demasiado corta</span>
                            <span x-show="password.length >= 8" x-transition class="text-xs font-bold text-emerald-500">Longitud válida ✓</span>
                        </div>
                        <input type="password" id="password" name="password" required placeholder=" " x-model="password"
                            class="input-floating block w-full px-4 pt-6 pb-2 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none"
                            :class="{'border-red-400 focus:ring-red-500 focus:border-red-500': password.length > 0 && password.length < 8, 'border-emerald-400 focus:ring-emerald-500 focus:border-emerald-500': password.length >= 8}">
                        <label for="password" class="absolute left-4 top-10 text-slate-400 text-sm transition-all pointer-events-none font-medium" :class="{'text-red-500': password.length > 0 && password.length < 8, 'text-emerald-500': password.length >= 8}">
                            Contraseña
                        </label>
                    </div>
                    
                    <!-- Campo Confirmar Contraseña -->
                    <div class="relative">
                        <div class="flex justify-between items-end mb-1 px-1">
                            <span class="text-xs font-semibold text-slate-500">Confirmación</span>
                            <span x-show="password_confirmation.length > 0 && password !== password_confirmation" x-transition class="text-xs font-bold text-red-500">Las contraseñas no coinciden</span>
                            <span x-show="password_confirmation.length > 0 && password === password_confirmation && password.length >= 8" x-transition class="text-xs font-bold text-emerald-500">Coinciden ✓</span>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder=" " x-model="password_confirmation"
                            class="input-floating block w-full px-4 pt-6 pb-2 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none"
                            :class="{'border-red-400 focus:ring-red-500 focus:border-red-500': password_confirmation.length > 0 && password !== password_confirmation, 'border-emerald-400 focus:ring-emerald-500 focus:border-emerald-500': password_confirmation.length > 0 && password === password_confirmation && password.length >= 8}">
                        <label for="password_confirmation" class="absolute left-4 top-10 text-slate-400 text-sm transition-all pointer-events-none font-medium" :class="{'text-red-500': password_confirmation.length > 0 && password !== password_confirmation, 'text-emerald-500': password_confirmation.length > 0 && password === password_confirmation && password.length >= 8}">
                            Confirmar Contraseña
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-xl text-base font-bold text-white bg-blue-900 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-900/30 transition-all shadow-[0_10px_20px_-10px_rgba(30,58,138,0.5)] transform hover:-translate-y-0.5 mt-4">
                    <span>Registrarse</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </button>
            </form>
            
            <div class="mt-8 pt-8 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500 font-medium">
                    ¿Ya tienes una cuenta? 
                    <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 transition-colors ml-1">Inicia Sesión</a>
                </p>
            </div>

            <!-- Pie de página -->
            <div class="mt-12 text-center">
                <p class="text-slate-400 text-xs font-medium">
                    &copy; {{ date('Y') }} Universidad Nacional de Piura. Deportes.
                </p>
            </div>

        </div>
    </div>
</body>
</html>
