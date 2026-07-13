@extends('components.layouts.app')

@section('title', 'Mis Reservas | UNP')

@section('content')
    <div class="mb-8 border-b border-slate-200 pb-4">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Historial de Reservas</h2>
        <p class="text-slate-500 mt-2 font-medium">Revisa el estado de tus solicitudes de canchas e instalaciones deportivas.</p>
    </div>

    <!-- Alertas Modernas -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50/80 backdrop-blur border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-start gap-3 shadow-sm transform transition-all" role="alert">
            <svg class="w-6 h-6 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline font-medium text-sm mt-0.5">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50/80 backdrop-blur border border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-start gap-3 shadow-sm transform transition-all" role="alert">
            <svg class="w-6 h-6 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline font-medium text-sm mt-0.5">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tabla Data-Grid -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Cancha / Sede</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Fecha Programada</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Horario</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($reservas as $reserva)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">{{ $reserva->cancha->nombre }}</div>
                                        <div class="text-xs font-medium text-slate-500 mt-0.5">{{ $reserva->cancha->ubicacion }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-700 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($reserva->fecha)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-700 bg-slate-100 px-3 py-1 rounded-full inline-block border border-slate-200">
                                    {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($reserva->estado === 'Pendiente')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5 mt-1.5"></span> Pendiente
                                    </span>
                                @elseif($reserva->estado === 'Aprobada')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 mt-1.5"></span> Aprobada
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5 mt-1.5"></span> {{ $reserva->estado }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm text-slate-500">
                                @php
                                    $fechaHoraInicio = \Carbon\Carbon::parse($reserva->fecha . ' ' . $reserva->hora_inicio);
                                    $esFutura = $fechaHoraInicio->isFuture();
                                    $horasFaltantes = now()->diffInHours($fechaHoraInicio, false);
                                    $puedeCancelar = $esFutura && $horasFaltantes >= 2 && !in_array($reserva->estado, ['Cancelada', 'Rechazada']);
                                @endphp
                                
                                @if($puedeCancelar)
                                    <form id="cancel-form-{{ $reserva->id }}" action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" onclick="openCancelModal('{{ $reserva->id }}')" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors border border-red-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Cancelar
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs font-medium text-slate-400 bg-slate-100 px-2.5 py-1.5 rounded-lg border border-slate-200">
                                        @if($reserva->estado === 'Cancelada')
                                            Cancelada
                                        @elseif(in_array($reserva->estado, ['Rechazada']))
                                            Rechazada
                                        @elseif(!$esFutura)
                                            Completada
                                        @else
                                            No cancelable
                                        @endif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Aún no tienes reservas</h3>
                                    <p class="text-sm text-slate-500 mt-1">Cuando solicites una instalación, aparecerá aquí.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Cancelación -->
    <div id="cancelModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all p-6 md:p-8 max-h-[90vh] overflow-y-auto">
            <!-- Icono de advertencia -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6 shadow-inner">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <h3 class="text-xl font-extrabold text-center text-slate-900 mb-2">¿Cancelar Reserva?</h3>
            <p class="text-sm text-slate-500 text-center mb-8 leading-relaxed font-medium">
                Estás a punto de cancelar tu solicitud. Esta acción liberará la cancha para otros estudiantes y no se puede deshacer.
            </p>
            
            <div class="flex flex-col gap-3">
                <button type="button" onclick="confirmCancel()" class="w-full inline-flex justify-center items-center rounded-xl px-4 py-3 bg-red-600 text-sm font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500/30 transition-all shadow-md">
                    Sí, cancelar definitivamente
                </button>
                <button type="button" onclick="closeCancelModal()" class="w-full inline-flex justify-center items-center rounded-xl px-4 py-3 bg-white border-2 border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-300 focus:outline-none transition-all">
                    No, mantener mi reserva
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentReservaId = null;

        function openCancelModal(reservaId) {
            currentReservaId = reservaId;
            const modal = document.getElementById('cancelModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
            }, 10);
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.add('hidden');
            currentReservaId = null;
        }

        function confirmCancel() {
            if (currentReservaId) {
                const form = document.getElementById('cancel-form-' + currentReservaId);
                if (form) {
                    form.submit();
                }
            }
        }
    </script>
    @endpush
@endsection
