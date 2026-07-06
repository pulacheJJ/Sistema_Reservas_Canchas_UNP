@extends('components.layouts.app')

@section('title', 'Gestión de Canchas | Administrador')

@section('content')
    <div class="mb-8 border-b pb-4 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Catálogo de Instalaciones</h2>
            <p class="text-gray-600 mt-2">Agrega nuevas canchas o deshabilita (Mantenimiento) las existentes.</p>
        </div>
        <button onclick="document.getElementById('modal-cancha').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nueva Instalación
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($canchas as $cancha)
            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col border border-gray-200">
                <div class="h-40 w-full bg-gray-200 relative">
                    <img src="{{ filter_var($cancha->imagen, FILTER_VALIDATE_URL) ? $cancha->imagen : asset('images/' . $cancha->imagen) }}" alt="{{ $cancha->nombre }}" class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3 px-2 py-1 rounded text-xs font-bold uppercase shadow-sm {{ $cancha->estado === 'Disponible' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $cancha->estado }}
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-800">{{ $cancha->nombre }}</h3>
                    <p class="text-xs text-gray-500 mt-1 mb-2">{{ $cancha->ubicacion }} | {{ $cancha->tipo }}</p>
                    
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <form action="{{ route('admin.canchas.estado', $cancha->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 text-sm rounded-lg font-medium transition-colors border {{ $cancha->estado === 'Disponible' ? 'border-red-200 text-red-700 bg-red-50 hover:bg-red-100' : 'border-green-200 text-green-700 bg-green-50 hover:bg-green-100' }}">
                                {{ $cancha->estado === 'Disponible' ? 'Poner en Mantenimiento' : 'Habilitar Instalación' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Agregar Cancha -->
    <div id="modal-cancha" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-bold text-gray-800">Nueva Instalación</h3>
                <button onclick="document.getElementById('modal-cancha').classList.add('hidden')" class="text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
            </div>
            
            <form action="{{ route('admin.canchas.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border" placeholder="Ej. Cancha Norte">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo / Deporte</label>
                    <input type="text" name="tipo" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border" placeholder="Ej. Básquetbol">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ubicación</label>
                    <input type="text" name="ubicacion" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border" placeholder="Ej. Campus Principal">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Capacidad (Personas)</label>
                    <input type="number" name="capacidad" min="1" value="10" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Descripción (Opcional)</label>
                    <textarea name="descripcion" rows="2" class="mt-1 block w-full border-gray-300 rounded-md p-2 border" placeholder="Ej. Cancha de césped natural con iluminación."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">URL de Imagen o Nombre de Archivo</label>
                    <input type="text" name="imagen" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border" placeholder="Ej. campus-unp.jpg o https://...">
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-medium">Guardar Instalación</button>
                </div>
            </form>
        </div>
    </div>
@endsection
