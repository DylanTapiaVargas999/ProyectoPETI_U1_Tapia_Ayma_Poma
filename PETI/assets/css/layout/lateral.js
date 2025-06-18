// FUNCIÓN PARA MOSTRAR/OCULTAR MENÚ DE PERFIL
function toggleProfileMenu() {
    const dropdown = document.querySelector('.profile-dropdown');
    const arrow = document.querySelector('.dropdown-arrow');
    
    if (dropdown && arrow) {
        dropdown.classList.toggle('show');
        arrow.classList.toggle('rotate');
    }
}

// Cerrar dropdown al hacer clic fuera
document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.profile-dropdown');
    const userInfo = document.querySelector('.user-info');
    
    if (dropdown && userInfo && !userInfo.contains(event.target) && dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        const arrow = document.querySelector('.dropdown-arrow');
        if (arrow) {
            arrow.classList.remove('rotate');
        }
    }
});

// FUNCIÓN PARA ABRIR MODAL DE LOGIN
function abrirModalLogin() {
    console.log("Modal de login abierto");
    alert('Modal de login en desarrollo');
}

// ACTIVAR ELEMENTOS DEL MENÚ PRINCIPAL
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const currentUrl = window.location.href;
    const menuItems = document.querySelectorAll('.menu-item');
    
    // DEBUGGING: Mostrar los elementos del menú
    console.log('Total menu items:', menuItems.length);
    console.log('Current URL:', currentUrl);
    console.log('Current Path:', currentPath);
    
    menuItems.forEach((item, index) => {
        const link = item.querySelector('a');
        if (link) {
            console.log(`${index}: ${link.textContent.trim()} -> ${link.getAttribute('href')}`);
        }
    });
    
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        if (link) {
            const href = link.getAttribute('href');
            
            // Comprobar si la URL actual coincide con el enlace
            if (href && (currentUrl.includes(href) || currentPath.includes(href.split('/').pop()))) {
                item.classList.add('active');
            }
            
            // Agregar evento click
            link.addEventListener('click', function(e) {
                // Remover clase active de todos los items
                menuItems.forEach(i => i.classList.remove('active'));
                // Agregar clase active al item clickeado
                item.classList.add('active');
            });
        }
    });
    
    // Detectar página actual
    detectCurrentPage();
});

// Función para detectar página actual - MAPEO ACTUALIZADO
function detectCurrentPage() {
    const currentPath = window.location.pathname;
    const currentUrl = window.location.href;
    const menuItems = document.querySelectorAll('.menu-item');
    
    console.log('Detecting current page...');
    console.log('Current path:', currentPath);
    console.log('Current URL:', currentUrl);
    
    // MAPEO ACTUALIZADO CON NUEVO ORDEN
    let routeIndex = -1;
    
    // Verificar rutas específicas PRIMERO (más específicas a menos específicas)
    if (currentPath.includes('dashboard')) {
        routeIndex = 0; // Dashboard - AHORA PRIMERA POSICIÓN
        console.log('Matched: Dashboard');
    } else if (currentPath.includes('resumen')) {
        routeIndex = 1; // Resumen Ejecutivo - NUEVA POSICIÓN
        console.log('Matched: Resumen Ejecutivo');
    } else if (currentPath.includes('mision')) {
        routeIndex = 2; // Misión - NUEVA POSICIÓN
        console.log('Matched: Misión');
    } else if (currentPath.includes('vision')) {
        routeIndex = 3; // Visión - NUEVA POSICIÓN
        console.log('Matched: Visión');
    } else if (currentPath.includes('valor')) {
        routeIndex = 4; // Valores - NUEVA POSICIÓN
        console.log('Matched: Valores');
    } else if (currentPath.includes('plan')) {
        routeIndex = 5; // Objetivos - NUEVA POSICIÓN
        console.log('Matched: Objetivos');
    } else if (currentPath.includes('analisis/info') || currentUrl.includes('analisis/info')) {
        routeIndex = 6; // Análisis FODA - NUEVA POSICIÓN
        console.log('Matched: Análisis FODA (analisis/info)');
    } else if (currentPath.includes('analisis/index') || currentUrl.includes('analisis/index')) {
        routeIndex = 7; // Cadena de Valor - NUEVA POSICIÓN
        console.log('Matched: Cadena de Valor (analisis/index)');
    } else if (currentPath.includes('BCG') || currentPath.includes('bcg')) {
        routeIndex = 8; // Matriz BCG - NUEVA POSICIÓN
        console.log('Matched: Matriz BCG');
    } else if (currentPath.includes('porter')) {
        routeIndex = 9; // 5 Fuerzas Porter - NUEVA POSICIÓN
        console.log('Matched: 5 Fuerzas Porter');
    } else if (currentPath.includes('pestel')) {
        routeIndex = 10; // Análisis PESTEL - NUEVA POSICIÓN
        console.log('Matched: Análisis PESTEL');
    } else if (currentPath.includes('foda')) {
        routeIndex = 11; // Estrategias - NUEVA POSICIÓN
        console.log('Matched: Estrategias');
    } else if (currentPath.includes('came')) {
        routeIndex = 12; // Matriz CAME - NUEVA POSICIÓN
        console.log('Matched: Matriz CAME');
    }
    
    // Si encontramos una coincidencia, activar el elemento
    if (routeIndex !== -1) {
        setActiveMenuItem(routeIndex);
    } else {
        console.log('No route match found for:', currentPath);
    }
}

// Función para marcar un item como activo
function setActiveMenuItem(itemIndex) {
    const menuItems = document.querySelectorAll('.menu-item');
    console.log(`Setting active item at index: ${itemIndex}`);
    
    menuItems.forEach((item, index) => {
        if (index === itemIndex) {
            item.classList.add('active');
            console.log(`✅ Activated item ${index}:`, item.querySelector('a')?.textContent.trim());
        } else {
            item.classList.remove('active');
        }
    });
}

// Función para alternar sidebar en móviles
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.classList.toggle('open');
    }
}