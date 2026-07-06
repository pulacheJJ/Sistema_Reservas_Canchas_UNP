@extends('components.layouts.app')

@section('title', 'Panel de Administración | UNP')

@section('content')
    <div class="mb-8 border-b pb-4">
        <h2 class="text-3xl font-bold text-gray-800">Panel de Administración</h2>
        <p class="text-gray-600 mt-2">Bienvenido, {{ Auth::user()->name }}. Desde aquí puedes gestionar las reservas y recintos deportivos.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Canchas y Recintos</h3>
            <p class="text-gray-500 text-sm mt-2">Administrar la disponibilidad, estado y características de los espacios deportivos.</p>
            <a href="{{ route('admin.canchas.index') }}" class="mt-4 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg font-medium hover:bg-blue-100 transition-colors w-full block">Gestionar Recintos</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Reservas</h3>
            <p class="text-gray-500 text-sm mt-2">Revisar, aprobar o cancelar solicitudes de reserva de estudiantes y docentes.</p>
            <a href="{{ route('admin.reservas.index') }}" class="mt-4 px-4 py-2 bg-green-50 text-green-600 rounded-lg font-medium hover:bg-green-100 transition-colors w-full block">Ver Reservas</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Usuarios</h3>
            <p class="text-gray-500 text-sm mt-2">Gestionar las cuentas de estudiantes y docentes que acceden al sistema.</p>
            <a href="{{ route('admin.usuarios.index') }}" class="mt-4 px-4 py-2 bg-purple-50 text-purple-600 rounded-lg font-medium hover:bg-purple-100 transition-colors w-full block">Gestionar Usuarios</a>
        </div>

    </div>
@endsection
