<div id="modal-reserva" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 transition-opacity p-2 sm:p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl p-4 sm:p-6 transform transition-all scale-95 max-h-[calc(100dvh-1rem)] sm:max-h-[90vh] overflow-y-auto" id="modal-content">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-xl font-bold text-gray-800">Configurar Reserva</h3>
            <button id="btn-cerrar-modal" class="text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-8">
            <!-- Columna Izquierda: Calendario -->
            <div class="border-r pr-4 hidden lg:block">
                <p class="text-sm text-gray-600 mb-2 font-medium">Disponibilidad en tiempo real:</p>
                <div id="modal-calendar" class="min-h-[400px]"></div>
            </div>

            <!-- Columna Derecha: Formulario -->
            <div>
                <form action="{{ route('reservas.store') }}" method="POST" id="form-reserva" class="space-y-4">
                    @csrf
                    <input type="hidden" id="cancha_id" name="cancha_id">
                    
                    <div class="bg-blue-50 p-3 rounded text-sm text-blue-900 border border-blue-100 mb-4">
                        Instalación seleccionada: <strong id="cancha-nombre-display"></strong>
                    </div>

                    @if(Auth::user()->isAdmin())
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200 mb-4 shadow-sm">
                            <label for="codigo_estudiante" class="block text-sm font-bold text-purple-800 mb-1 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Reserva Presencial (Solo Admin)
                            </label>
                            <input type="text" id="codigo_estudiante" name="codigo_estudiante" placeholder="Código/DNI del usuario"
                                class="mt-1 block w-full border-purple-300 rounded-md shadow-sm focus:border-purple-600 focus:ring-purple-600 p-2 border text-sm"
                                title="Si ingresas un Código/DNI, la reserva y el mensaje de WhatsApp se asignarán a ese usuario.">
                            <p class="text-[10px] text-purple-600 mt-1 mt-1 font-medium">Opcional. Si lo dejas en blanco, la reserva quedará a tu nombre.</p>
                        </div>
                    @endif

                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="date" id="fecha" name="fecha" required min="{{ date('Y-m-d') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-800 focus:ring-blue-800 p-2 border">
                    </div>
                    
                    <div>
                        <label for="horario_bloque" class="block text-sm font-medium text-gray-700">Horario disponible</label>
                        <select id="horario_bloque" required disabled
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-800 focus:ring-blue-800 p-2 border bg-white disabled:bg-gray-100 disabled:text-gray-400">
                            <option value="">Primero selecciona una fecha</option>
                        </select>
                        <input type="hidden" id="hora_inicio" name="hora_inicio">
                        <input type="hidden" id="hora_fin" name="hora_fin">
                        <p id="horario-ayuda" class="text-xs text-gray-500 mt-1">Selecciona una fecha para consultar los bloques libres.</p>
                    </div>

                    <div class="pt-4 flex flex-col-reverse sm:flex-row gap-3">
                        <button type="button" id="btn-cancelar" class="flex-1 bg-white border border-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-50 transition-colors font-medium">Cancelar</button>
                        <button type="submit" class="flex-1 bg-blue-800 text-white py-2 rounded-md hover:bg-blue-900 transition-colors shadow-md font-medium">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
