<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Profesional</title>
    <link rel="stylesheet" href="<?=base_url?>assets/css/layout/lateral.css">
    <link rel="stylesheet" href="<?=base_url?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- BARRA LATERAL -->
    <div class="sidebar modern-sidebar">
        <!-- ENCABEZADO -->
        <div class="sidebar-header">
            <h2>Estrategia Corporativa</h2>
            <span class="plan-badge">PETI</span>
            
            <!-- Mostrar el plan seleccionado -->
            <?php if (isset($_SESSION['plan_codigo'])): ?>
                <div class="selected-plan">
                    <i class="fas fa-file-alt"></i>
                    Plan activo: <strong><?= $_SESSION['plan_codigo'] ?></strong>
                </div>
                <!-- Botón para cambiar el plan -->
                <form action="<?=base_url?>planEstrategico/cambiar" method="POST" id="form-cambiar-plan">
                    <button type="submit" class="btn-change-plan">Cambiar Plan</button>
                </form>
            <?php else: ?>
                <div class="selected-plan text-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    No hay plan seleccionado
                </div>
            <?php endif; ?>
        </div>
        
        <!-- CONTENIDO DEL MENÚ -->
        <div class="menu-container">
            <!-- Sección Principal - Dashboard primero -->
            <div class="menu-section">
                <h3 class="menu-title">Principal</h3>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="<?=base_url?>dashboard/index">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=base_url?>resumen/index">
                            <i class="fas fa-chart-pie"></i>
                            Resumen Ejecutivo
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Sección Fundamentos -->
            <div class="menu-section">
                <h3 class="menu-title">Fundamentos</h3>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="<?=base_url?>mision/index">
                            <i class="fas fa-bullseye"></i>
                            1. Misión
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=base_url?>vision/index">
                            <i class="fas fa-eye"></i>
                            2. Visión
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=base_url?>valor/index">
                            <i class="fas fa-gem"></i>
                            3. Valores
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=base_url?>plan/index">
                            <i class="fas fa-flag-checkered"></i>
                            4. Objetivos
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Sección Análisis -->
            <div class="menu-section">
                <h3 class="menu-title">Análisis Estratégico</h3>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="<?=base_url?>analisis/info">
                            <i class="fas fa-search"></i>
                            5. Análisis FODA
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=base_url?>analisis/index">
                            <i class="fas fa-link"></i>
                            6. Cadena de Valor
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=base_url?>BCG/index">
                            <i class="fas fa-th"></i>
                            7. Matriz BCG
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=base_url?>porter/index">
                            <i class="fas fa-chess-board"></i>
                            8. 5 Fuerzas Porter
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=base_url?>pestel/index">
                            <i class="fas fa-globe"></i>
                            9. Análisis PESTEL
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Sección Estrategia -->
            <div class="menu-section">
                <h3 class="menu-title">Formulación</h3>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="<?=base_url?>foda/index">
                            <i class="fas fa-chess-queen"></i>
                            10. Estrategias
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?=base_url?>came/index">
                            <i class="fas fa-table"></i>
                            11. Matriz CAME
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- PIE DE PÁGINA CON USUARIO -->
        <div class="sidebar-footer">
            <div class="user-profile">
                <?php if (!isset($_SESSION['identity'])): ?>
                    <!-- Botón de login cuando no hay sesión -->
                    <button class="user-info btn-login" onclick="abrirModalLogin()">
                        <i class="fas fa-user-circle"></i>
                        <div class="user-welcome">
                            <span class="welcome-text">Inicia Sesión</span>
                            <span class="user-name">Acceder al Sistema</span>
                        </div>
                        <i class="fas fa-sign-in-alt"></i>
                    </button>
                <?php else: ?>
                    <!-- Información del usuario con dropdown -->
                    <button class="user-info" onclick="toggleProfileMenu()">
                        <i class="fas fa-user-circle"></i>
                        <div class="user-welcome">
                            <span class="welcome-text">Bienvenido</span>
                            <span class="user-name"><?= $_SESSION['identity']->empresa ?? 'Usuario' ?></span>
                        </div>
                        <i class="fas fa-chevron-down dropdown-arrow" id="footer-arrow"></i>
                    </button>
                    
                    <!-- Dropdown del usuario -->
                    <div class="profile-dropdown" id="footer-dropdown">
                        <a href="<?= base_url ?>usuario/perfil" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            Mi Perfil
                        </a>
                        <a href="<?= base_url ?>dashboard/index" class="dropdown-item">
                            <i class="fas fa-chart-bar"></i>
                            Dashboard
                        </a>
                        <a href="<?= base_url ?>planEstrategico/cambiar" class="dropdown-item">
                            <i class="fas fa-exchange-alt"></i>
                            Cambiar Plan
                        </a>
                        <hr style="margin: 0.5rem 0; border: none; border-top: 1px solid #e5e7eb;">
                        <a href="<?= base_url ?>usuario/cerrarSesion" class="dropdown-item logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Cerrar Sesión
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <main style="margin-left: 280px; padding: 20px;">
        <!-- Tu contenido principal aquí -->
    </main>

    <script src="<?=base_url?>assets/css/layout/lateral.js"></script>

</body>
</html>