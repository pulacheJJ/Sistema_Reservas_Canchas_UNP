@extends('components.layouts.app')

@section('title', 'Calendario | UNP')

@push('styles')
    <!-- FullCalendar CSS CDN -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
@endpush

@section('content')
    <div class="mb-6 border-b pb-4">
        <h2 class="text-3xl font-bold text-gray-800">Calendario de Ocupabilidad</h2>
        <p class="text-gray-600 mt-2">Revisa qué horarios están ocupados antes de hacer tu reserva.</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <!-- Selector de Cancha -->
        <div class="mb-6 flex items-center gap-4">
            <label for="cancha-selector" class="font-medium text-gray-700">Ver horarios de:</label>
            <select id="cancha-selector" class="border-gray-300 rounded-md shadow-sm focus:border-blue-800 focus:ring-blue-800 p-2 border min-w-[250px]">
                <option value="" disabled selected>Selecciona una cancha...</option>
                @foreach($canchas as $cancha)
                    <option value="{{ $cancha->id }}">{{ $cancha->nombre }} - {{ $cancha->ubicacion }}</option>
                @endforeach
            </select>
        </div>

        <!-- Contenedor del Calendario -->
        <div id='calendar-container' class="hidden transition-opacity duration-300">
            <div id='calendar' class="min-h-[600px]"></div>
        </div>

        <div id="calendar-placeholder" class="py-20 text-center text-gray-400 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <p>Selecciona una cancha en el menú desplegable para ver su disponibilidad.</p>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- FullCalendar JS CDN -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var selector = document.getElementById('cancha-selector');
            var container = document.getElementById('calendar-container');
            var placeholder = document.getElementById('calendar-placeholder');
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                slotMinTime: '06:00:00',
                slotMaxTime: '23:00:00',
                allDaySlot: false,
                height: 700,
                events: [] // Se cargará dinámicamente
            });

            calendar.render();

            selector.addEventListener('change', function() {
                var canchaId = this.value;
                if(canchaId) {
                    placeholder.classList.add('hidden');
                    container.classList.remove('hidden');
                    
                    // Remover fuente anterior y agregar la nueva desde la API
                    calendar.removeAllEventSources();
                    calendar.addEventSource('/api/canchas/' + canchaId + '/horarios');
                    
                    // Forzar re-renderizado
                    setTimeout(() => {
                        calendar.updateSize();
                    }, 100);
                }
            });
        });
    </script>
@endpush
