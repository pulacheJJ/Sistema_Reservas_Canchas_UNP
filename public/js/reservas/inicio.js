document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-reserva');
    const modalContent = document.getElementById('modal-content');
    const btnCerrar = document.getElementById('btn-cerrar-modal');
    const btnCancelar = document.getElementById('btn-cancelar');
    
    const inputCanchaId = document.getElementById('cancha_id');
    const spanCanchaNombre = document.getElementById('cancha-nombre-display');

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
            slotMinTime: '06:00:00',
            slotMaxTime: '23:00:00',
            allDaySlot: false,
            height: '100%',
            events: '/api/canchas/' + canchaId + '/horarios',
            selectable: true,
            select: function(info) {
                // Auto-completar el formulario al hacer clic en el calendario
                const startDate = new Date(info.start);
                const endDate = new Date(info.end);
                
                // Formatear a YYYY-MM-DD
                document.getElementById('fecha').value = startDate.toISOString().split('T')[0];
                
                // Formatear a HH:MM
                const formatTime = (date) => date.toTimeString().split(' ')[0].substring(0,5);
                document.getElementById('hora_inicio').value = formatTime(startDate);
                document.getElementById('hora_fin').value = formatTime(endDate);
            }
        });

        calendar.render();
    }

    // Abrir Modal
    document.querySelectorAll('.btn-abrir-modal').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            
            // Llenar datos en el formulario
            inputCanchaId.value = id;
            spanCanchaNombre.textContent = nombre;
            
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