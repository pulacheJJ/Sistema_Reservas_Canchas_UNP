@extends('components.layouts.app')

@section('title', 'Calendario | UNP')

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <style>
        /* Personalización de FullCalendar para adaptarlo a la estética Premium */
        .fc-theme-standard .fc-scrollgrid { border: none !important; }
        .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9 !important; }
        .fc-col-header-cell-cushion { padding: 12px 8px !important; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; }
        .fc-daygrid-day-number { font-weight: 600; color: #334155; padding: 8px !important; }
        .fc .fc-button-primary { background-color: #fff !important; color: #334155 !important; border: 1px solid #e2e8f0 !important; font-weight: 600; text-transform: capitalize; border-radius: 8px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .fc .fc-button-primary:hover { background-color: #f8fafc !important; border-color: #cbd5e1 !important; color: #2563eb !important; }
        .fc .fc-button-primary:not(:disabled):active, .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #eff6ff !important; border-color: #bfdbfe !important; color: #1d4ed8 !important; }
        .fc .fc-toolbar-title { font-weight: 800; color: #1e293b; font-size: 1.5rem; text-transform: capitalize; }
        .fc-event { border: none !important; padding: 2px 4px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .fc-day-today { background-color: #f0fdf4 !important; }
    </style>
@endpush

@section('content')
    <div class="mb-6 sm:mb-8 border-b border-slate-200 pb-4">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Calendario General</h2>
        <p class="text-slate-500 mt-2 font-medium">Visualiza los horarios ocupados de todas las instalaciones antes de reservar.</p>
    </div>

    <!-- Filtros de Cancha -->
    <div class="mb-6 sm:mb-8 bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-sm">
        <label for="filtroCancha" class="block text-sm font-bold text-slate-700 mb-3">Filtrar por Instalación Deportiva:</label>
        <select id="filtroCancha" class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-slate-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-xl bg-slate-50 border transition-colors">
            <option value="todas">🎯 Todas las Instalaciones</option>
            @foreach($canchas as $cancha)
                <option value="{{ $cancha->id }}">{{ $cancha->nombre }} ({{ $cancha->ubicacion }})</option>
            @endforeach
        </select>
    </div>

    <!-- Contenedor del Calendario -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-2 sm:p-4 md:p-8 overflow-x-auto touch-scroll">
            <div id='calendar' class="w-full"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var selectCancha = document.getElementById('filtroCancha');
            
            // Pasar los datos de PHP a JS de forma segura
            var allEvents = @json($eventos);
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 640 ? 'listWeek' : 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: window.innerWidth < 640 ? 'listWeek,dayGridMonth' : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                events: allEvents,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                displayEventEnd: true,
                dayMaxEvents: true, // Allow "more" link when too many events
                eventDidMount: function(info) {
                    // Estilizar según el estado si lo tiene
                    if (info.event.extendedProps.estado === 'Aprobada') {
                        info.el.style.backgroundColor = '#10b981'; // emerald-500
                    } else if (info.event.extendedProps.estado === 'Pendiente') {
                        info.el.style.backgroundColor = '#f59e0b'; // amber-500
                    } else {
                        // Color base para eventos si no tienen estado (ej. de DB)
                        info.el.style.backgroundColor = '#3b82f6'; // blue-500
                    }
                }
            });
            
            calendar.render();

            // Filtrado
            selectCancha.addEventListener('change', function() {
                var canchaId = this.value;
                
                var filteredEvents = allEvents.filter(function(event) {
                    if (canchaId === 'todas') return true;
                    // Aseguramos que comparamos strings o enteros correctamente
                    return event.cancha_id == canchaId;
                });
                
                calendar.removeAllEvents();
                calendar.addEventSource(filteredEvents);
            });
        });
    </script>
@endpush
