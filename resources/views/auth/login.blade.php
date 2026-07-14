<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Deportes UNP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body x-data="{ showForgotModal: false, showPassword: false }" class="min-h-screen relative flex items-center justify-center overflow-hidden bg-slate-900">
    
    <!-- Fondo dinámico (Imagen con overlay) -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/login-inicio.jpeg') }}" class="w-full h-full object-cover opacity-40 mix-blend-overlay" alt="Background">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/90 via-blue-900/80 to-slate-900/90"></div>
    </div>

    <!-- Blobs decorativos de colores vibrantes -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 blob-1 z-0 translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 blob-2 z-0 -translate-x-1/2 translate-y-1/2"></div>
    <div class="absolute top-1/2 left-1/4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 blob-3 z-0"></div>

    <!-- Contenedor Principal (Glassmorphism) -->
    <div class="relative z-10 w-full max-w-[1000px] flex flex-col md:flex-row glass-card rounded-2xl md:rounded-3xl overflow-hidden mx-4">
        
        <!-- Lado Izquierdo (Branding) -->
        <div class="w-full md:w-5/12 bg-gradient-to-br from-blue-600 to-blue-800 p-10 flex flex-col justify-between text-white relative overflow-hidden hidden md:flex">
            <!-- Patrón de fondo sutil -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white to-transparent"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-12">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center p-2 border border-white/20 shadow-inner">
                        <img src="{{ asset('images/logo-unp.png') }}" alt="UNP" class="w-full h-full object-contain filter drop-shadow-lg">
                    </div>
                    <span class="font-bold text-xl tracking-widest uppercase text-blue-50">Deportes</span>
                </div>

                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight mb-6">
                    Tu espacio.<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-emerald-200">Tu juego.</span>
                </h1>
                <p class="text-blue-100/90 font-light text-lg leading-relaxed">
                    Sistema oficial de reservas de instalaciones deportivas de la Universidad Nacional de Piura.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-3 text-sm text-blue-200/80 font-medium bg-black/10 w-fit px-4 py-2 rounded-full border border-white/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span>Acceso Seguro</span>
            </div>
        </div>

        <!-- Lado Derecho (Formulario) -->
        <div class="w-full md:w-7/12 p-8 md:p-12 lg:p-16 bg-white/90">
            
            <!-- Logo Móvil -->
            <div class="md:hidden flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center p-1.5 shadow-lg">
                    <img src="{{ asset('images/logo-unp.png') }}" alt="UNP" class="w-full h-full object-contain">
                </div>
                <span class="font-bold text-xl tracking-widest uppercase text-slate-800">Deportes</span>
            </div>

            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2 tracking-tight">Bienvenido</h2>
                <p class="text-slate-500 font-medium">Ingresa tus credenciales para continuar.</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                @if($errors->has('loginError'))
                    <div class="bg-red-50/80 backdrop-blur border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-start gap-3 shadow-sm mb-6 transform transition-all animate-[bounce_0.5s_ease-in-out]" role="alert">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="block sm:inline font-medium text-sm">{{ $errors->first('loginError') }}</span>
                    </div>
                @endif

                <div class="space-y-5">
                    <!-- Campo Código -->
                    <div class="relative group">
                        <input type="text" id="codigo" name="codigo" required autofocus placeholder=" "
                            class="input-floating block w-full px-4 pt-6 pb-2 text-slate-900 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none group-hover:border-blue-400 shadow-sm"
                            value="{{ old('codigo') }}">
                        <label for="codigo" class="absolute left-4 top-4 text-slate-500 text-sm transition-all pointer-events-none font-semibold">
                            Código Institucional
                        </label>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="relative group">
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required placeholder=" "
                            class="input-floating block w-full pl-4 pr-12 pt-6 pb-2 text-slate-900 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none group-hover:border-blue-400 shadow-sm">
                        <label for="password" class="absolute left-4 top-4 text-slate-500 text-sm transition-all pointer-events-none font-semibold">
                            Contraseña
                        </label>
                        <!-- Botón Mostrar/Ocultar -->
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 focus:outline-none transition-colors">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 015.458-5.925M21.542 12a10.04 10.04 0 01-2.925 3.925M15 12a3 3 0 01-3 3M3 3l18 18"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600 transition-colors cursor-pointer accent-blue-600">
                        <label for="remember-me" class="ml-2 block text-sm text-slate-600 font-medium cursor-pointer select-none">
                            Recordarme
                        </label>
                    </div>
                    <div class="text-sm">
                        <button type="button" @click="showForgotModal = true" class="font-bold text-blue-600 hover:text-blue-800 transition-colors">
                            ¿Olvidaste tu clave?
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-xl text-base font-bold text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-4 focus:ring-blue-600/30 transition-all shadow-lg shadow-blue-600/30 transform hover:-translate-y-1">
                    <span>Ingresar al Sistema</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
            
            <div class="mt-8 pt-8 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500 font-medium">
                    ¿Nuevo en el campus? 
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 transition-colors ml-1 relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:bg-blue-600 after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:origin-left">
                        Crea tu cuenta aquí
                    </a>
                </p>
            </div>

        </div>
    </div>

    <!-- Modal Olvidaste Contraseña -->
    <div x-show="showForgotModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div x-show="showForgotModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showForgotModal = false"></div>
        
        <!-- Contenido -->
        <div x-show="showForgotModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center z-10">
             
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-6">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            
            <h3 class="text-xl font-extrabold text-slate-900 mb-2">Recuperación de Cuenta</h3>
            <p class="text-sm text-slate-500 font-medium mb-6">
                Por motivos de seguridad, para restablecer tu contraseña debes acercarte presencialmente a la <strong>Oficina de Deportes</strong> o contactar al administrador del sistema.
            </p>
            
            <button type="button" @click="showForgotModal = false" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                Entendido
            </button>
        </div>
    </div>
</body>
</html>