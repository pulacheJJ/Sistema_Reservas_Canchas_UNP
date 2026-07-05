@extends('components.layouts.app')

@section('title', 'Control de Reservas | Administrador')

@section('content')
    <div class="mb-8 flex justify-between items-end border-b pb-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Control de Reservas</h2>
            <p class="text-gray-600 mt-2">Aprueba, rechaza o bloquea fechas por eventos especiales.</p>
        </div>
        <button onclick="document.getElementById('modal-evento').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow-sm font-medium flex items-center gap-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Bloquear por Evento
        </button>
    </div>

    <!-- Modal Crear Evento -->
    <div id="modal-evento" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-bold text-gray-800">Registrar Evento / Torneo</h3>
                <button onclick="document.getElementById('modal-evento').classList.add('hidden')" class="text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
            </div>
            <form action="{{ route('admin.evento.crear') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Título del Evento</label>
                    <input type="text" name="titulo_evento" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border" placeholder="Ej. Juegos Universitarios">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cancha a Bloquear</label>
                    <select name="cancha_id" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border">
                        @foreach(\App\Models\Cancha::where('estado', 'Disponible')->get() as $cancha)
                            <option value="{{ $cancha->id }}">{{ $cancha->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha del Evento (Todo el día)</label>
                    <input type="date" name="fecha" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border">
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 font-medium">Bloquear Cancha</button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitante</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cancha Solicitada</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Día y Hora</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($reservas as $reserva)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $reserva->user->name }}</div>
                            <div class="text-xs text-gray-500">Cód: {{ $reserva->user->codigo }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $reserva->cancha->nombre }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-blue-900">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</div>
                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($reserva->estado === 'Pendiente')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pendiente
                                </span>
                            @elseif($reserva->estado === 'Aprobada')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aprobada
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Rechazada
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($reserva->estado === 'Pendiente')
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.reservas.estado', $reserva->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="estado" value="Aprobada">
                                        <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md transition-colors text-xs shadow-sm">
                                            Aprobar
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reservas.estado', $reserva->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="estado" value="Rechazada">
                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md transition-colors text-xs shadow-sm">
                                            Rechazar
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="flex gap-2">
                                    <span class="text-gray-400 text-xs italic">Procesada</span>
                                    @if($reserva->estado === 'Rechazada')
                                        <button onclick="document.getElementById('modal-sancion-{{ $reserva->id }}').classList.remove('hidden')" class="text-white bg-purple-600 hover:bg-purple-700 px-2 py-1 rounded-md transition-colors text-xs shadow-sm ml-2">
                                            Sancionar
                                        </button>
                                        
                                        <!-- Modal Sancionar -->
                                        <div id="modal-sancion-{{ $reserva->id }}" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
                                            <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 text-left whitespace-normal">
                                                <div class="flex justify-between items-center border-b pb-3 mb-4">
                                                    <h3 class="text-xl font-bold text-gray-800">Sancionar Alumno</h3>
                                                    <button onclick="document.getElementById('modal-sancion-{{ $reserva->id }}').classList.add('hidden')" class="text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
                                                </div>
                                                <form action="{{ route('admin.sancionar') }}" method="POST" class="space-y-4">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $reserva->user->id }}">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Motivo</label>
                                                        <input type="text" name="motivo" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border" placeholder="Ej. No se presentó a su reserva">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Fecha de Fin (Penalidad)</label>
                                                        <input type="date" name="fecha_fin" required class="mt-1 block w-full border-gray-300 rounded-md p-2 border">
                                                    </div>
                                                    <div class="pt-2">
                                                        <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-md hover:bg-purple-700 font-medium">Aplicar Sanción</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 text-center">
                            No hay reservas en el sistema.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
