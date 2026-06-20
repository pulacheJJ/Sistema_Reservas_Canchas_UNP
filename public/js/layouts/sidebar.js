document.addEventListener('DOMContentLoaded', () => {
    
    const formLogout = document.getElementById('form-logout');
    
    if (formLogout) {
        formLogout.addEventListener('submit', function(e) {
            // Prevenimos el envío inmediato al backend
            e.preventDefault();
            
            // Lógica de confirmación (Se puede reemplazar por SweetAlert en el futuro)
            const confirmar = confirm("¿Estás seguro que deseas cerrar sesión en el sistema de reservas?");
            
            if (confirmar) {
                // Si acepta, ejecutamos la acción POST hacia Laravel
                this.submit();
            }
        });
    }

    // Lógica adicional del Sidebar (Ej: Marcar activo según la URL)
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.sidebar-nav a');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('bg-blue-800', 'border-blue-700');
            link.classList.remove('border-transparent');
        }
    });

});