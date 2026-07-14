@extends('components.layouts.app')

@section('title', 'Reportes y Estadísticas | UNP')

@section('content')
<div class="flex justify-between items-center mb-8 border-b pb-4">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Panel de Estadísticas</h2>
        <p class="text-gray-600 mt-2">Métricas de uso y rendimiento de las instalaciones deportivas.</p>
    </div>
    <div>
        <button onclick="exportarPDF()" id="btn-export" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm flex items-center gap-2 print:hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Exportar a PDF</span>
        </button>
    </div>
</div>

<div id="reporte-pdf-content" class="bg-gray-50 p-4 rounded-xl">

<!-- KPIs (Key Performance Indicators) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Reservas</p>
            <p class="text-3xl font-bold text-gray-800">{{ $kpis['total_reservas'] }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Aprobadas</p>
            <p class="text-3xl font-bold text-gray-800">{{ $kpis['reservas_aprobadas'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
        <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Canchas Disp.</p>
            <p class="text-3xl font-bold text-gray-800">{{ $kpis['canchas_disponibles'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
        <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Sancionados</p>
            <p class="text-3xl font-bold text-gray-800">{{ $kpis['alumnos_sancionados'] }}</p>
        </div>
    </div>
</div>

<!-- Gráficos (Charts) -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10 break-inside-avoid">
    <!-- Gráfico 1: Estado de las reservas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Estado Histórico de Reservas</h3>
        <div class="relative flex-1 w-full flex justify-center items-center" style="min-height: 300px;">
            <canvas id="chartEstados"></canvas>
        </div>
    </div>

    <!-- Gráfico 2: Canchas más utilizadas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Ranking de Instalaciones (Top 5)</h3>
        <div class="relative flex-1 w-full flex justify-center items-center" style="min-height: 300px;">
            <canvas id="chartCanchas"></canvas>
        </div>
    </div>
</div>

</div>

<style>
    @media print {
        @page { size: landscape; margin: 10mm; }
        body { background-color: white !important; }
        .print\:hidden { display: none !important; }
        aside, nav, header { display: none !important; }
        main { margin: 0 !important; padding: 0 !important; width: 100% !important; max-width: 100% !important; }
        .shadow-sm { box-shadow: none !important; }
        .border { border: 1px solid #e5e7eb !important; }
        #reporte-pdf-content { background: white !important; padding: 0 !important; margin: 0 !important; width: 100% !important; }
        .bg-white { background-color: white !important; }
        /* Forzar que los gráficos impriman sus colores */
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function exportarPDF() {
        // Usamos el motor de PDF nativo del navegador (Print to PDF)
        // Es 100% más rápido, no se cuelga y genera PDFs vectoriales (no imágenes borrosas)
        window.print();
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Datos inyectados desde Laravel
        const estadosLabels = {!! json_encode($chartEstados['labels']) !!};
        const estadosData = {!! json_encode($chartEstados['data']) !!};
        
        const canchasLabels = {!! json_encode($chartCanchas['labels']) !!};
        const canchasData = {!! json_encode($chartCanchas['data']) !!};

        // Paleta de colores deportivos / vibrantes
        const coloresDona = ['#10b981', '#ef4444', '#f59e0b', '#6b7280']; // Verde, Rojo, Naranja, Gris
        const coloresBarras = ['#3b82f6', '#8b5cf6', '#ec4899', '#f43f5e', '#f97316'];

        // Mapear colores por estado si es posible
        const mappedColoresDona = estadosLabels.map(estado => {
            if(estado === 'Aprobada') return '#10b981';
            if(estado === 'Rechazada') return '#ef4444';
            if(estado === 'Pendiente') return '#f59e0b';
            return '#6b7280';
        });

        // Gráfico 1: Doughnut (Estado de reservas)
        const ctxEstados = document.getElementById('chartEstados').getContext('2d');
        new Chart(ctxEstados, {
            type: 'doughnut',
            data: {
                labels: estadosLabels,
                datasets: [{
                    data: estadosData,
                    backgroundColor: mappedColoresDona.length > 0 ? mappedColoresDona : coloresDona,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 20, font: { family: "'Inter', sans-serif" } }
                    }
                },
                cutout: '70%'
            }
        });

        // Gráfico 2: Bar (Uso por Cancha)
        const ctxCanchas = document.getElementById('chartCanchas').getContext('2d');
        new Chart(ctxCanchas, {
            type: 'bar',
            data: {
                labels: canchasLabels,
                datasets: [{
                    label: 'Cantidad de Reservas',
                    data: canchasData,
                    backgroundColor: coloresBarras,
                    borderRadius: 6,
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4] },
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
