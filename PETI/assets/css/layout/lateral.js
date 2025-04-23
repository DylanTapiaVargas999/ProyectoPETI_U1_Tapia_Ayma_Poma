// FUNCIÓN PARA MOSTRAR/OCULTAR MENÚ DE PERFIL (VERSIÓN ANTERIOR)
function toggleProfileMenu() {
    const dropdown = document.querySelector('.profile-dropdown');
    const arrow = document.querySelector('.dropdown-arrow');
    
    dropdown.classList.toggle('show');
    arrow.classList.toggle('rotate');
}

// CERRAR MENÚ AL HACER CLIC FUERA (VERSIÓN MEJORADA)
document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.profile-dropdown');
    const userBtn = document.querySelector('.user-info');
    
    if (!userBtn.contains(event.target) && dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        document.querySelector('.dropdown-arrow').classList.remove('rotate');
    }
});

// FUNCIÓN PARA ABRIR MODAL DE LOGIN (MANTENIENDO TU VERSIÓN)
function abrirModalLogin() {
    // Aquí iría tu lógica para abrir el modal de login
    console.log("Modal de login abierto");
    // Ejemplo: document.getElementById('modal-login').style.display = 'block';
}

// ACTIVAR ELEMENTOS DEL MENÚ PRINCIPAL
document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.menu-item').forEach(i => {
            i.classList.remove('active');
        });
        this.classList.add('active');
    });
});