document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-reserva');
    const modalContent = document.getElementById('modal-content');
    const btnCerrar = document.getElementById('btn-cerrar-modal');
    const btnCancelar = document.getElementById('btn-cancelar');
    
    const inputCanchaId = document.getElementById('cancha_id');
    const spanCanchaNombre = document.getElementById('cancha-nombre-display');

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
            }, 10);
        });
    });

    // Cerrar Modal
    const cerrarModal = () => {
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('form-reserva').reset();
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