@extends('components.layouts.app')

@section('title', 'Mis Reservas | UNP')

@section('content')
    <div class="mb-8 border-b pb-4">
        <h2 class="text-3xl font-bold text-gray-800">Mis Reservas</h2>
        <p class="text-gray-600 mt-2">Revisa el estado de tus solicitudes de canchas.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cancha / Instalación</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registrada el</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($reservas as $reserva)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $reserva->cancha->nombre }}</div>
                                    <div class="text-sm text-gray-500">{{ $reserva->cancha->ubicacion }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}</div>
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
                                    {{ $reserva->estado }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @php
                                $fechaHoraInicio = \Carbon\Carbon::parse($reserva->fecha . ' ' . $reserva->hora_inicio);
                                $esFutura = $fechaHoraInicio->isFuture();
                                $horasFaltantes = now()->diffInHours($fechaHoraInicio, false);
                                $puedeCancelar = $esFutura && $horasFaltantes >= 2 && !in_array($reserva->estado, ['Cancelada', 'Rechazada']);
                            @endphp
                            
                            @if($puedeCancelar)
                                <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta reserva?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                        Cancelar
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">
                                    @if($reserva->estado === 'Cancelada')
                                        Cancelada
                                    @elseif(in_array($reserva->estado, ['Rechazada']))
                                        Rechazada
                                    @elseif(!$esFutura)
                                        Pasada
                                    @else
                                        No cancelable (< 2h)
                                    @endif
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 text-center">
                            Aún no has realizado ninguna reserva.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
