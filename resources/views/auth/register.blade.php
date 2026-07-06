<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Reservas Deportivas UNP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        
        .bg-left-panel {
            background-image: url('https://images.unsplash.com/photo-1518609878373-06d740f60d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
        }

        .input-floating:focus + label,
        .input-floating:not(:placeholder-shown) + label {
            transform: translateY(-1.5rem) scale(0.85);
            color: #2563eb;
        }
    </style>
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
                <p class="text-xs font-bold text-red-500">* Solo se permiten correos @alumnos.unp.edu.pe</p>
            </div>

            <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
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
                    
                    <!-- Campo Codigo -->
                    <div class="relative">
                        <input type="text" id="codigo" name="codigo" required autofocus placeholder=" "
                            class="input-floating block w-full px-4 pt-6 pb-2 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none"
                            value="{{ old('codigo') }}">
                        <label for="codigo" class="absolute left-4 top-4 text-slate-400 text-sm transition-all pointer-events-none font-medium">
                            Código Institucional
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
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder=" "
                            class="input-floating block w-full px-4 pt-6 pb-2 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none">
                        <label for="password" class="absolute left-4 top-4 text-slate-400 text-sm transition-all pointer-events-none font-medium">
                            Contraseña
                        </label>
                    </div>
                    
                    <!-- Campo Confirmar Contraseña -->
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder=" "
                            class="input-floating block w-full px-4 pt-6 pb-2 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none">
                        <label for="password_confirmation" class="absolute left-4 top-4 text-slate-400 text-sm transition-all pointer-events-none font-medium">
                            Confirmar Contraseña
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex justify-center items-center gap-2 py-4 px-4 rounded-xl text-sm font-bold text-white bg-blue-900 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-900/30 transition-all shadow-[0_10px_20px_-10px_rgba(30,58,138,0.5)] transform hover:-translate-y-0.5 mt-4">
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
