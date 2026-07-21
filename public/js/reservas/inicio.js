document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-reserva');
    const modalContent = document.getElementById('modal-content');
    const btnCerrar = document.getElementById('btn-cerrar-modal');
    const btnCancelar = document.getElementById('btn-cancelar');
    
    const inputCanchaId = document.getElementById('cancha_id');
    const spanCanchaNombre = document.getElementById('cancha-nombre-display');
    const inputFecha = document.getElementById('fecha');
    const selectHorario = document.getElementById('horario_bloque');
    const inputHoraInicio = document.getElementById('hora_inicio');
    const inputHoraFin = document.getElementById('hora_fin');
    const horarioAyuda = document.getElementById('horario-ayuda');

    let calendar = null;
    const calendarEl = document.getElementById('modal-calendar');

    // Inicializar Calendario
    function initCalendar(canchaId) {
        if (calendar) {
            calendar.destroy();
        }

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },
            slotMinTime: '09:00:00',
            slotMaxTime: '22:00:00',
            slotDuration: '01:00:00',
            slotLabelInterval: '01:00:00',
            allDaySlot: false,
            height: '100%',
            events: '/api/canchas/' + canchaId + '/horarios',
            dateClick: function(info) {
                inputFecha.value = info.dateStr.substring(0, 10);
                cargarHorariosDisponibles();
            }
        });

        calendar.render();
    }

    function limpiarHorario(mensaje = 'Selecciona una fecha para consultar los bloques libres.') {
        selectHorario.innerHTML = '<option value="">' + mensaje + '</option>';
        selectHorario.disabled = true;
        inputHoraInicio.value = '';
        inputHoraFin.value = '';
        horarioAyuda.textContent = mensaje;
    }

    function horaConDosDigitos(hora) {
        return String(hora).padStart(2, '0') + ':00';
    }

    async function cargarHorariosDisponibles() {
        const canchaId = inputCanchaId.value;
        const fecha = inputFecha.value;

        if (!canchaId || !fecha) {
            limpiarHorario();
            return;
        }

        limpiarHorario('Consultando disponibilidad...');

        try {
            const respuesta = await fetch('/api/canchas/' + canchaId + '/horarios', {
                headers: { 'Accept': 'application/json' }
            });

            if (!respuesta.ok) {
                throw new Error('No se pudo consultar la disponibilidad.');
            }

            const eventos = await respuesta.json();
            const bloquesDisponibles = [];

            for (let hora = 9; hora < 22; hora++) {
                const inicio = horaConDosDigitos(hora);
                const fin = horaConDosDigitos(hora + 1);
                const inicioBloque = fecha + 'T' + inicio + ':00';
                const finBloque = fecha + 'T' + fin + ':00';
                const bloqueYaPaso = new Date(inicioBloque) < new Date();

                const ocupado = eventos.some(evento => {
                    if (!evento.start || !evento.end || evento.start.substring(0, 10) !== fecha) {
                        return false;
                    }

                    return evento.start < finBloque && evento.end > inicioBloque;
                });

                if (!ocupado && !bloqueYaPaso) {
                    bloquesDisponibles.push({ inicio, fin });
                }
            }

            selectHorario.innerHTML = '<option value="">Selecciona un bloque</option>';

            bloquesDisponibles.forEach(bloque => {
                const opcion = document.createElement('option');
                opcion.value = bloque.inicio + '|' + bloque.fin;
                opcion.textContent = bloque.inicio + ' - ' + bloque.fin;
                selectHorario.appendChild(opcion);
            });

            if (bloquesDisponibles.length === 0) {
                limpiarHorario('No hay horarios disponibles para esta fecha.');
                return;
            }

            selectHorario.disabled = false;
            horarioAyuda.textContent = bloquesDisponibles.length + ' bloques disponibles entre las 09:00 y las 22:00.';
        } catch (error) {
            limpiarHorario('No se pudo cargar la disponibilidad. Inténtalo nuevamente.');
        }
    }

    inputFecha.addEventListener('change', cargarHorariosDisponibles);

    selectHorario.addEventListener('change', function() {
        if (!this.value) {
            inputHoraInicio.value = '';
            inputHoraFin.value = '';
            return;
        }

        [inputHoraInicio.value, inputHoraFin.value] = this.value.split('|');
    });

    // Abrir Modal
    document.querySelectorAll('.btn-abrir-modal').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            
            // Llenar datos en el formulario
            inputCanchaId.value = id;
            spanCanchaNombre.textContent = nombre;
            inputFecha.value = '';
            limpiarHorario();
            
            // Mostrar
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
                
                // Inicializar calendario después de que el modal es visible
                if (calendarEl) {
                    initCalendar(id);
                }
            }, 50); // Dar un poco más de tiempo para que la animación fluya
        });
    });

    // Cerrar Modal
    const cerrarModal = () => {
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('form-reserva').reset();
            limpiarHorario();
            if (calendar) calendar.destroy();
        }, 200); // match transition duration
    };

    btnCerrar.addEventListener('click', cerrarModal);
    btnCancelar.addEventListener('click', cerrarModal);

    // Cerrar si hace clic fuera del modal
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            cerrarModal();
        }
    });
});
