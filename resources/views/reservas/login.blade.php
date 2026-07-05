<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Reservas Deportivas UNP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        
        .bg-sports {
            background-image: url('{{ asset('images/bg-sports.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .glass-panel {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Neon glow animation for the button */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 15px rgba(16, 185, 129, 0.5); }
            50% { box-shadow: 0 0 25px rgba(16, 185, 129, 0.8), 0 0 40px rgba(16, 185, 129, 0.4); }
        }
        .btn-neon {
            animation: pulse-glow 3s infinite;
        }
        
        /* Floating animation for logo */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-sports min-h-screen flex items-center justify-center p-4 relative overflow-hidden text-white">
    
    <!-- Overlay oscuro para mejorar la legibilidad -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/80 via-slate-900/60 to-slate-900/90 z-0"></div>

    <div class="w-full max-w-md z-10 flex flex-col items-center">
        <!-- Encabezado / Logo Deportivo -->
        <div class="text-center mb-10 w-full animate-float">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-emerald-400 to-blue-600 mb-6 shadow-[0_0_30px_rgba(16,185,129,0.3)] border-4 border-slate-900/50 relative">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-white drop-shadow-md">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12 4.5c3.275 0 6.096 1.954 7.375 4.81l-3.32-3.32a.75.75 0 0 0-1.06 1.06l3.86 3.86A7.472 7.472 0 0 1 19.5 12c0 2.222-.968 4.22-2.5 5.61l-3.32-3.32a.75.75 0 0 0-1.06 1.06l3.86 3.86C15.096 20.296 12.275 22.25 9 22.25A7.472 7.472 0 0 1 4.5 12c0-2.222.968-4.22 2.5-5.61l3.32 3.32a.75.75 0 1 0 1.06-1.06l-3.86-3.86C6.404 3.454 9.225 1.5 12.5 1.5Z" clip-rule="evenodd" />
                    <!-- Elemento deportivo -->
                    <circle cx="12" cy="12" r="3" fill="white" />
                </svg>
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-blue-400 drop-shadow-sm uppercase">UNP Sports</h1>
            <p class="text-slate-300 mt-2 text-sm font-medium tracking-[0.2em] uppercase">Sistema de Reservas Deportivas</p>
        </div>

        <!-- Tarjeta de Login -->
        <div class="glass-panel rounded-3xl w-full p-8 transition-all hover:border-emerald-500/30">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white mb-2">Bienvenido al juego</h2>
                <p class="text-slate-400 text-sm">Ingresa tus credenciales para reservar tu cancha.</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                @if($errors->has('loginError'))
                    <div class="bg-red-500/20 border border-red-500/50 text-red-200 px-4 py-3 rounded-xl relative text-sm backdrop-blur-md shadow-inner flex items-start gap-3" role="alert">
                        <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span class="block sm:inline font-medium">{{ $errors->first('loginError') }}</span>
                    </div>
                @endif

                <div>
                    <label for="codigo" class="block text-sm font-medium text-slate-300 mb-2 uppercase tracking-wider text-xs">Código Institucional</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-emerald-400 text-slate-500">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="codigo" name="codigo" required autofocus
                            class="block w-full pl-12 pr-4 py-3.5 bg-slate-900/50 border border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-white placeholder-slate-500 transition-all hover:bg-slate-900/80 outline-none"
                            placeholder="Ej. 2023123456" value="{{ old('codigo') }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2 uppercase tracking-wider text-xs">Contraseña</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-emerald-400 text-slate-500">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="block w-full pl-12 pr-4 py-3.5 bg-slate-900/50 border border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-white placeholder-slate-500 transition-all hover:bg-slate-900/80 outline-none"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 bg-slate-900 border-slate-700 text-emerald-500 focus:ring-emerald-500 rounded cursor-pointer transition-colors outline-none">
                        <label for="remember-me" class="ml-2 block text-sm text-slate-400 cursor-pointer select-none hover:text-white transition-colors">
                            Recordarme
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-emerald-400 hover:text-emerald-300 transition-colors">
                            ¿Olvidaste tu clave?
                        </a>
                    </div>
                </div>

                <button type="submit"
                    class="btn-neon w-full mt-4 flex justify-center items-center gap-2 py-4 px-4 border border-transparent rounded-xl text-sm font-bold text-slate-900 bg-gradient-to-r from-emerald-400 to-emerald-500 hover:from-emerald-300 hover:to-emerald-400 focus:outline-none transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest">
                    <span>Entrar a la Cancha</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </button>
            </form>
            
            <div class="mt-8 rounded-xl bg-slate-900/40 border border-slate-800 p-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="h-5 w-5 text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-1">Credenciales de Acceso</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm text-slate-400">
                            <div>
                                <span class="block text-[10px] text-slate-500 uppercase">Estudiante</span>
                                2023123456 / 87654321
                            </div>
                            <div>
                                <span class="block text-[10px] text-slate-500 uppercase">Admin</span>
                                admin / admin123
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pie de página -->
        <p class="text-center text-slate-500 text-xs mt-10 relative z-10 font-medium tracking-wide">
            &copy; {{ date('Y') }} Universidad Nacional de Piura. Deportes.
        </p>
    </div>
</body>
</html>