@extends('components.layouts.app')

@section('title', 'Gestión de Canchas | Administrador')

@section('content')
    <div class="mb-8 border-b pb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Catálogo de Instalaciones</h2>
            <p class="text-gray-600 mt-2">Agrega nuevas canchas o deshabilita (Mantenimiento) las existentes.</p>
        </div>
        <button onclick="document.getElementById('modal-cancha').classList.remove('hidden')" class="w-full sm:w-auto bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition font-medium flex justify-center items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nueva Instalación
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($canchasAgrupadas->isNotEmpty())
        <div x-data="{ tab: '{{ array_key_first($canchasAgrupadas->toArray()) }}' }">
            
            <!-- Navegación de Pestañas -->
            <div class="touch-scroll flex border-b border-gray-200 mb-6 space-x-6 overflow-x-auto no-scrollbar snap-x">
                @foreach($canchasAgrupadas as $ubicacion => $canchas)
                    <button @click="tab = '{{ $ubicacion }}'" 
                            :class="tab === '{{ $ubicacion }}' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap pb-3 px-1 border-b-2 font-semibold text-sm transition-colors">
                        {{ $ubicacion }}
                    </button>
                @endforeach
            </div>

            <!-- Contenido de las Pestañas -->
            @foreach($canchasAgrupadas as $ubicacion => $canchas)
                <div x-show="tab === '{{ $ubicacion }}'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6" style="display: none;">
                    @foreach($canchas as $cancha)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col border border-gray-200 transition-transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="h-40 w-full bg-gray-200 relative">
                                <img src="{{ filter_var($cancha->imagen, FILTER_VALIDATE_URL) ? $cancha->imagen : asset('images/' . $cancha->imagen) }}" alt="{{ $cancha->nombre }}" class="w-full h-full object-cover">
                                <div class="absolute top-3 right-3 px-2 py-1 rounded text-xs font-bold uppercase shadow-sm {{ $cancha->estado === 'Disponible' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $cancha->estado }}
                                </div>
                            </div>
                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-800">{{ $cancha->nombre }}</h3>
                                <div class="mt-1 flex items-center gap-2">
                                    <span class="inline-block bg-blue-50 text-blue-800 border border-blue-100 text-xs px-2 py-0.5 rounded">
                                        {{ $cancha->tipo }}
                                    </span>
                                </div>

                                @if(!empty($cancha->descripcion))
                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2" title="{{ $cancha->descripcion }}">
                                        {{ $cancha->descripcion }}
                                    </p>
                                @endif
                                
                                <div class="mt-auto pt-4 border-t border-gray-100 space-y-2">
                                    <div class="flex gap-2">
                                        <button onclick="document.getElementById('modal-edit-{{ $cancha->id }}').classList.remove('hidden')" class="flex-1 py-1.5 text-sm rounded-lg font-medium border border-blue-200 text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                                            Editar
                                        </button>
                                        <button type="button" onclick="document.getElementById('modal-delete-{{ $cancha->id }}').classList.remove('hidden')" class="flex-1 py-1.5 text-sm rounded-lg font-medium border border-gray-200 text-gray-700 bg-gray-50 hover:bg-red-50 hover:text-red-700 hover:border-red-200 transition-colors">
                                            Eliminar
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.canchas.estado', $cancha->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-1.5 text-sm rounded-lg font-medium transition-colors border {{ $cancha->estado === 'Disponible' ? 'border-orange-200 text-orange-700 bg-orange-50 hover:bg-orange-100' : 'border-green-200 text-green-700 bg-green-50 hover:bg-green-100' }}">
                                            {{ $cancha->estado === 'Disponible' ? 'Pausar (Mantenimiento)' : 'Habilitar Instalación' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Editar Cancha -->
                        <div id="modal-edit-{{ $cancha->id }}" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-2 sm:p-4">
                            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-4 sm:p-6 max-h-[calc(100dvh-1rem)] sm:max-h-[90vh] overflow-y-auto">
                                <div class="flex justify-between items-center border-b pb-3 mb-4">
                                    <h3 class="text-xl font-bold text-gray-800">Editar Instalación</h3>
                                    <button onclick="document.getElementById('modal-edit-{{ $cancha->id }}').classList.add('hidden')" class="text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
                                </div>
                                
                                <form action="{{ route('admin.canchas.update', $cancha->id) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input type="text" name="nombre" value="{{ $cancha->nombre }}" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tipo / Deporte</label>
                                        <input type="text" name="tipo" value="{{ $cancha->tipo }}" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Ubicación</label>
                                        <input type="text" name="ubicacion" value="{{ $cancha->ubicacion }}" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Capacidad (Personas)</label>
                                        <input type="number" name="capacidad" min="1" value="{{ $cancha->capacidad ?? 10 }}" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Descripción (Opcional)</label>
                                        <textarea name="descripcion" rows="2" class="mt-1 block w-full border-gray-300 rounded-md p-2 border">{{ $cancha->descripcion }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Imagen de la Cancha (Dejar en blanco para mantener actual)</label>
                                        <input type="file" name="imagen" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md p-2 border">
                                    </div>
                                    <div class="pt-4">
                                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-medium">Actualizar Instalación</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Confirmar Eliminación -->
                        <div id="modal-delete-{{ $cancha->id }}" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-[60] p-2 sm:p-4">
                            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-4 sm:p-6 text-center max-h-[calc(100dvh-1rem)] overflow-y-auto">
                                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">¿Eliminar Instalación?</h3>
                                <p class="text-gray-500 mb-6">Estás a punto de eliminar permanentemente la cancha <strong>"{{ $cancha->nombre }}"</strong>. Esta acción no se puede deshacer.</p>
                                
                                <div class="flex flex-col-reverse sm:flex-row gap-3 w-full">
                                    <button type="button" onclick="document.getElementById('modal-delete-{{ $cancha->id }}').classList.add('hidden')" class="flex-1 bg-gray-100 text-gray-700 py-2.5 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                                        Cancelar
                                    </button>
                                    <form action="{{ route('admin.canchas.destroy', $cancha->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-600 text-white py-2.5 rounded-lg font-medium hover:bg-red-700 transition-colors">
                                            Sí, eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-10 bg-white rounded-xl border">
            <p class="text-gray-500">No hay instalaciones registradas en el sistema.</p>
        </div>
    @endif

    <!-- Modal Agregar Cancha -->
    <div id="modal-cancha" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-2 sm:p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-4 sm:p-6 max-h-[calc(100dvh-1rem)] sm:max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-bold text-gray-800">Nueva Instalación</h3>
                <button onclick="document.getElementById('modal-cancha').classList.add('hidden')" class="text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
            </div>
            
            <form action="{{ route('admin.canchas.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
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
                    <label class="block text-sm font-medium text-gray-700">Imagen de la Cancha</label>
                    <input type="file" name="imagen" accept="image/*" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border">
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-medium">Guardar Instalación</button>
                </div>
            </form>
        </div>
    </div>
@endsection
