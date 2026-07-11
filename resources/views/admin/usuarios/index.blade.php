@extends('components.layouts.app')

@section('title', 'Gestión de Usuarios | UNP')

@section('content')
    <div class="mb-8 border-b pb-4 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Gestión de Usuarios</h2>
            <p class="text-gray-600 mt-2">Administra los roles y contraseñas de las cuentas registradas.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-sm">
                        <th class="p-4 font-semibold">ID</th>
                        <th class="p-4 font-semibold">Nombre y Apellidos</th>
                        <th class="p-4 font-semibold">Código / Doc.</th>
                        <th class="p-4 font-semibold">Correo</th>
                        <th class="p-4 font-semibold">Rol</th>
                        <th class="p-4 font-semibold text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-50">
                    @forelse($usuarios as $user)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="p-4 text-gray-500">#{{ $user->id }}</td>
                            <td class="p-4 font-medium text-gray-800">{{ $user->name }}</td>
                            <td class="p-4 text-gray-600">{{ $user->codigo }}</td>
                            <td class="p-4 text-gray-600">{{ $user->email }}</td>
                            <td class="p-4">
                                @if($user->isAdmin())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Administrador
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        Estudiante
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 flex items-center justify-center gap-2">
                                @if(auth()->id() !== $user->id)
                                    <!-- Formulario para Reset Password -->
                                    <form action="{{ route('admin.usuarios.reset-password', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de restablecer la contraseña de {{ $user->name }} a unp123456?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-xs font-medium rounded border border-red-300 text-red-600 hover:bg-red-50 transition-colors" title="Restablecer Contraseña">
                                            Reset Password
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400 italic">Tú (Sesión actual)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                No se encontraron usuarios en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
