<div id="modal-reserva" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 transition-opacity">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 transform transition-all scale-95" id="modal-content">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-xl font-bold text-gray-800">Configurar Reserva</h3>
            <button id="btn-cerrar-modal" class="text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
        </div>
        
        <form action="#" method="POST" id="form-reserva" class="space-y-4">
            <input type="hidden" id="cancha_id" name="cancha_id">
            
            <div class="bg-blue-50 p-3 rounded text-sm text-blue-900 border border-blue-100 mb-4">
                Instalación seleccionada: <strong id="cancha-nombre-display"></strong>
            </div>

            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" id="fecha" name="fecha" required 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-800 focus:ring-blue-800 p-2 border">
            </div>
            
            <div>
                <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Horario de Inicio</label>
                <input type="time" id="hora_inicio" name="hora_inicio" required 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-800 focus:ring-blue-800 p-2 border">
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" id="btn-cancelar" class="flex-1 bg-white border border-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-50 transition-colors font-medium">Cancelar</button>
                <button type="submit" class="flex-1 bg-blue-800 text-white py-2 rounded-md hover:bg-blue-900 transition-colors shadow-md font-medium">Confirmar</button>
            </div>
        </form>
    </div>
</div>