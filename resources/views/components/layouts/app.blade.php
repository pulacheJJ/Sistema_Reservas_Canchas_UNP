<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reservas UNP')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans flex h-screen overflow-hidden">

    @include('components.layouts.sidebar')

    <main class="flex-1 flex flex-col overflow-hidden bg-gray-50 relative">
        <header class="bg-white shadow-sm border-b px-8 py-4 flex justify-between items-center z-10">
            <h2 class="text-lg font-semibold text-gray-700">Sistema de Reservas</h2>
            <div class="text-sm font-medium text-gray-500 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Sede Piura
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>