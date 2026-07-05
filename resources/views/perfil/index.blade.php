@extends('components.layouts.app')

@section('title', 'Mi Perfil | UNP')

@section('content')
    <div class="mb-8 border-b pb-4">
        <h2 class="text-3xl font-bold text-gray-800">Mi Perfil</h2>
        <p class="text-gray-600 mt-2">Actualiza tu información personal y de seguridad.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
        <form action="{{ route('perfil.update') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Información Personal</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Código Institucional</label>
                        <input type="text" value="{{ $user->codigo }}" disabled class="mt-1 block w-full border-gray-200 bg-gray-50 rounded-md p-2 border text-gray-500 cursor-not-allowed">
                        <p class="text-xs text-gray-400 mt-1">El código no puede ser modificado.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border focus:border-blue-800 focus:ring-blue-800">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Seguridad (Opcional)</h3>
                <p class="text-sm text-gray-500 mb-4">Solo llena estos campos si deseas cambiar tu contraseña.</p>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña Actual</label>
                        <input type="password" name="current_password" class="mt-1 block w-full border-gray-300 rounded-md p-2 border focus:border-blue-800 focus:ring-blue-800">
                        @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                        <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md p-2 border focus:border-blue-800 focus:ring-blue-800">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md p-2 border focus:border-blue-800 focus:ring-blue-800">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t flex justify-end">
                <button type="submit" class="bg-blue-800 text-white px-6 py-2 rounded-md hover:bg-blue-900 transition-colors shadow-md font-medium">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
