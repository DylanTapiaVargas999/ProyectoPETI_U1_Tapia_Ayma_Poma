<?php
// filepath: c:\xampp\htdocs\PETI\views\dashboard\index.php
?>
<link rel="stylesheet" href="<?= base_url ?>assets/css/dashboard.css">

<div class="dashboard-container">
    <!-- Header del Dashboard -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="dashboard-title">📊 Panel de Control</h1>
                <p class="dashboard-subtitle">
                    Plan Estratégico: <strong><?= htmlspecialchars($_SESSION['plan_codigo']) ?></strong>
                </p>
            </div>
            <div class="col-md-4 text-end">
                <div class="dashboard-date">
                    <?= date('d/m/Y') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Progreso General -->
    <div class="card mb-4 progress-card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="card-title">🎯 Progreso General del Plan</h5>
                    <div class="progress progress-main">
                        <div class="progress-bar" style="width: <?= $progreso['general'] ?>%"></div>
                    </div>
                    <small class="text-muted"><?= round($progreso['general']) ?>% completado</small>
                </div>
                <div class="col-md-4 text-center">
                    <div class="progress-circle" style="--progress: <?= $progreso['general'] ?>">
                        <div class="progress-text"><?= round($progreso['general']) ?>%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secciones del Plan -->
    <div class="row">
        <!-- Fundamentos -->
        <div class="col-md-6 mb-4">
            <div class="card section-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🏛️ Fundamentos</h5>
                </div>
                <div class="card-body">
                    <div class="section-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>1. Misión</span>
                            <div class="section-status">
                                <?php if ($progreso['mision'] > 0): ?>
                                    <span class="badge bg-success">✓ Completado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">⏳ Pendiente</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?= base_url ?>mision/index" class="btn btn-sm btn-outline-primary mt-2">
                            <?= $progreso['mision'] > 0 ? 'Ver/Editar' : 'Completar' ?>
                        </a>
                    </div>

                    <div class="section-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>2. Visión</span>
                            <div class="section-status">
                                <?php if ($progreso['vision'] > 0): ?>
                                    <span class="badge bg-success">✓ Completado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">⏳ Pendiente</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?= base_url ?>vision/index" class="btn btn-sm btn-outline-primary mt-2">
                            <?= $progreso['vision'] > 0 ? 'Ver/Editar' : 'Completar' ?>
                        </a>
                    </div>

                    <div class="section-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>3. Valores</span>
                            <div class="section-status">
                                <?php if ($progreso['valores'] > 0): ?>
                                    <span class="badge bg-success">✓ Completado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">⏳ Pendiente</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?= base_url ?>valor/index" class="btn btn-sm btn-outline-primary mt-2">
                            <?= $progreso['valores'] > 0 ? 'Ver/Editar' : 'Completar' ?>
                        </a>
                    </div>

                    <div class="section-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>4. Objetivos</span>
                            <div class="section-status">
                                <?php if ($progreso['objetivos'] > 0): ?>
                                    <span class="badge bg-success">✓ Completado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">⏳ Pendiente</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?= base_url ?>plan/index" class="btn btn-sm btn-outline-primary mt-2">
                            <?= $progreso['objetivos'] > 0 ? 'Ver/Editar' : 'Completar' ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Análisis Estratégico -->
        <div class="col-md-6 mb-4">
            <div class="card section-card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">🔍 Análisis Estratégico</h5>
                </div>
                <div class="card-body">
                    <div class="section-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>5. Análisis FODA</span>
                            <div class="section-status">
                                <?php if ($progreso['foda'] >= 100): ?>
                                    <span class="badge bg-success">✓ Completado</span>
                                <?php elseif ($progreso['foda'] > 0): ?>
                                    <span class="badge bg-warning"><?= $progreso['foda'] ?>% Parcial</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">⏳ Pendiente</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?= base_url ?>analisis/info" class="btn btn-sm btn-outline-info mt-2">
                            <?= $progreso['foda'] > 0 ? 'Continuar' : 'Iniciar' ?>
                        </a>
                    </div>

                    <div class="section-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>6. Cadena de Valor</span>
                            <div class="section-status">
                                <?php if ($progreso['cadena_valor'] > 0): ?>
                                    <span class="badge bg-success">✓ Completado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">⏳ Pendiente</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?= base_url ?>analisis/index" class="btn btn-sm btn-outline-info mt-2">
                            <?= $progreso['cadena_valor'] > 0 ? 'Ver Resultados' : 'Completar' ?>
                        </a>
                    </div>

                    <div class="section-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>7. Matriz BCG</span>
                            <div class="section-status">
                                <?php if ($progreso['bcg'] >= 100): ?>
                                    <span class="badge bg-success">✓ Completado</span>
                                <?php elseif ($progreso['bcg'] > 0): ?>
                                    <span class="badge bg-warning"><?= round($progreso['bcg']) ?>% Parcial</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">⏳ Pendiente</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?= base_url ?>bcg/index" class="btn btn-sm btn-outline-info mt-2">
                            <?= $progreso['bcg'] > 0 ? 'Continuar' : 'Iniciar' ?>
                        </a>
                    </div>

                    <div class="section-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>8. 5 Fuerzas Porter</span>
                            <div class="section-status">
                                <?php if ($progreso['porter'] > 0): ?>
                                    <span class="badge bg-success">✓ Completado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">⏳ Pendiente</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?= base_url ?>porter/index" class="btn btn-sm btn-outline-info mt-2">
                            <?= $progreso['porter'] > 0 ? 'Ver Resultados' : 'Completar' ?>
                        </a>
                    </div>

                    <div class="section-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>9. Análisis PESTEL</span>
                            <div class="section-status">
                                <?php if ($progreso['pestel'] > 0): ?>
                                    <span class="badge bg-success">✓ Completado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">⏳ Pendiente</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?= base_url ?>pestel/index" class="btn btn-sm btn-outline-info mt-2">
                            <?= $progreso['pestel'] > 0 ? 'Ver Resultados' : 'Completar' ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulación Estratégica -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card section-card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">🎯 Formulación Estratégica</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>10. Estrategias FODA</span>
                                    <div class="section-status">
                                        <span class="badge bg-info" id="estrategia-status">⏳ Verificando...</span>
                                    </div>
                                </div>
                                <a href="<?= base_url ?>foda/index" class="btn btn-sm btn-outline-success mt-2">
                                    Generar Estrategias
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="section-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>11. Matriz CAME</span>
                                    <div class="section-status">
                                        <?php if ($progreso['came'] >= 100): ?>
                                            <span class="badge bg-success">✓ Completado</span>
                                        <?php elseif ($progreso['came'] > 0): ?>
                                            <span class="badge bg-warning"><?= $progreso['came'] ?>% Parcial</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">⏳ Pendiente</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <a href="<?= base_url ?>came/index" class="btn btn-sm btn-outline-success mt-2">
                                    <?= $progreso['came'] > 0 ? 'Continuar' : 'Iniciar' ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">⚡ Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url ?>resumen/index" class="btn btn-success btn-block action-btn">
                                📄 Ver Resumen Completo
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url ?>resumen/exportarPdf" class="btn btn-danger btn-block action-btn" target="_blank">
                                📑 Exportar PDF
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url ?>planEstrategico/cambiar" class="btn btn-warning btn-block action-btn">
                                🔄 Cambiar Plan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button onclick="mostrarEstrategiaActual()" class="btn btn-info btn-block action-btn">
                                🎯 Estrategia Actual
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recomendaciones inteligentes -->
    <div class="card mt-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">💡 Recomendaciones</h5>
        </div>
        <div class="card-body">
            <div id="recomendaciones">
                <?php if ($progreso['general'] < 25): ?>
                    <div class="alert alert-info">
                        <strong>¡Empezemos!</strong> Te recomendamos comenzar definiendo la <a href="<?= base_url ?>mision/index">Misión</a> de tu empresa.
                    </div>
                <?php elseif ($progreso['general'] < 40): ?>
                    <div class="alert alert-warning">
                        <strong>¡Buen avance!</strong> Continúa completando los fundamentos básicos y define tus <a href="<?= base_url ?>plan/index">objetivos estratégicos</a>.
                    </div>
                <?php elseif ($progreso['general'] < 60): ?>
                    <div class="alert alert-primary">
                        <strong>¡Excelente progreso!</strong> Es momento de trabajar en el análisis estratégico: <a href="<?= base_url ?>analisis/info">FODA</a>, <a href="<?= base_url ?>bcg/index">BCG</a> y <a href="<?= base_url ?>porter/index">Porter</a>.
                    </div>
                <?php elseif ($progreso['general'] < 80): ?>
                    <div class="alert alert-info">
                        <strong>¡Casi listo!</strong> Completa las <a href="<?= base_url ?>foda/index">estrategias FODA</a> y la <a href="<?= base_url ?>came/index">matriz CAME</a> para finalizar tu plan.
                    </div>
                <?php else: ?>
                    <div class="alert alert-success">
                        <strong>¡Felicitaciones!</strong> Tu plan estratégico está completo. Puedes <a href="<?= base_url ?>resumen/index">revisar el resumen</a> o <a href="<?= base_url ?>resumen/exportarPdf" target="_blank">exportarlo a PDF</a>.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    verificarEstrategiasLocalStorage();
});

function verificarEstrategiasLocalStorage() {
    const tipo = localStorage.getItem('tipoEstrategiaFODA');
    const estrategiaStatus = document.getElementById('estrategia-status');
    
    if (tipo && tipo.trim() !== '') {
        estrategiaStatus.className = 'badge bg-success';
        estrategiaStatus.textContent = '✓ Completado';
    } else {
        estrategiaStatus.className = 'badge bg-warning';
        estrategiaStatus.textContent = '⏳ Pendiente';
    }
}

function mostrarEstrategiaActual() {
    const tipo = localStorage.getItem('tipoEstrategiaFODA');
    const descripcion = localStorage.getItem('descripcionEstrategiaFODA');
    
    if (tipo && descripcion) {
        alert(`🎯 ESTRATEGIA ACTUAL:\n\n${tipo}\n\n📝 ${descripcion}`);
    } else {
        alert('⚠️ Aún no has completado el análisis FODA.\n\nVe a la sección de Estrategias FODA para generar tu estrategia.');
    }
}

// Actualizar progreso de estrategias
window.addEventListener('storage', function(e) {
    if (e.key === 'tipoEstrategiaFODA') {
        verificarEstrategiasLocalStorage();
    }
});

// Verificar cada 5 segundos
setInterval(verificarEstrategiasLocalStorage, 5000);
</script>