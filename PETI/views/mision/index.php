<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Definición de Misión - PETI</title>
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url?>assets/css/layout/lateral.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
        }
        
        .main-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }
        
        .header-section {
     /* Marrón suave para contraste */
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .mission-display {
            background:rgba(255, 107, 53, 0.4);   /* Naranja pastel aún más claro */
            color: #5a3a1b;        /* Mismo marrón suave */
            border-radius: 12px;
            padding: 2rem;
            margin: 1.5rem 0;
        }
        
        .form-section {
            padding: 2rem;
        }
        
        .sidebar-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .btn-minimal {
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary-minimal {
            background: #3b82f6;
            color: white;
        }
        
        .btn-primary-minimal:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }
        
        .btn-secondary-minimal {
            background: #f1f5f9;
            color: #475569;
        }
        
        .btn-secondary-minimal:hover {
            background: #e2e8f0;
        }
        
        .progress-minimal {
            height: 4px;
            background: #f1f5f9;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .progress-fill-minimal {
            height: 100%;
            background: linear-gradient(90deg, #10b981, #059669);
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #64748b;
        }
        
        .icon-minimal {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- HEADER MINIMALISTA -->
        <div class="header-section">
            <h1 class="h2 mb-2 fw-normal">
                <i class="fas fa-bullseye me-2"></i>
                Definición de Misión
            </h1>
            <p class="mb-0 opacity-90">Establece el propósito fundamental de tu organización</p>
        </div>

        <div class="row g-4">
            <!-- CONTENIDO PRINCIPAL -->
            <div class="col-lg-8">
                <div class="main-card">
                    <!-- MISIÓN ACTUAL -->
                    <div class="border-bottom p-4">
                        <h4 class="h5 mb-3 d-flex align-items-center">
                            <i class="fas fa-target me-2 text-primary"></i>
                            Tu Misión Actual
                        </h4>
                        
                        <?php if ($misiones && $misiones->num_rows > 0): ?>
                            <?php $mision = $misiones->fetch_object(); ?>
                            <div class="mission-display">
                                <div class="text-center">
                                    <i class="fas fa-quote-left opacity-50 mb-3"></i>
                                    <p class="fs-6 mb-3 lh-lg fw-medium">
                                        <?= htmlspecialchars($mision->mision) ?>
                                    </p>
                                    <i class="fas fa-quote-right opacity-50"></i>
                                </div>
                                
                                <div class="d-flex gap-2 justify-content-center mt-3">
                                    <a href="<?= base_url ?>mision/index&editar=<?= $mision->id_mision ?>" 
                                       class="btn btn-minimal btn-secondary-minimal btn-sm">
                                        <i class="fas fa-edit me-1"></i> Editar
                                    </a>
                                    <a href="<?= base_url ?>mision/eliminar&id=<?= $mision->id_mision ?>" 
                                       class="btn btn-minimal btn-secondary-minimal btn-sm" 
                                       onclick="return confirm('¿Confirmas eliminar esta misión?')">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <div class="icon-minimal mx-auto bg-light">
                                    <i class="fas fa-plus text-muted"></i>
                                </div>
                                <h5 class="h6 mb-2">Sin misión definida</h5>
                                <p class="small mb-0">Define la razón de ser de tu organización</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- FORMULARIOS -->
                    <?php if (isset($edicion) && $edicion && isset($misionActual)): ?>
                        <div class="form-section">
                            <h5 class="h6 mb-3 d-flex align-items-center">
                                <i class="fas fa-edit me-2 text-primary"></i>
                                Editar Misión
                            </h5>
                            
                            <form action="<?= base_url ?>mision/guardar" method="POST">
                                <input type="hidden" name="id_mision" value="<?= $misionActual->id_mision ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-medium">Declaración de misión</label>
                                    <textarea name="mision" class="form-control" rows="5" 
                                              placeholder="Describe la razón de ser de tu organización..." 
                                              required><?= htmlspecialchars($misionActual->mision) ?></textarea>
                                </div>
                                
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="<?= base_url ?>mision/index" class="btn btn-minimal btn-secondary-minimal">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-minimal btn-primary-minimal">
                                        <i class="fas fa-save me-1"></i> Guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if (!$misiones || $misiones->num_rows == 0): ?>
                        <div class="form-section">
                            <h5 class="h6 mb-3 d-flex align-items-center">
                                <i class="fas fa-plus-circle me-2 text-primary"></i>
                                Crear Nueva Misión
                            </h5>
                            
                            <form action="<?= base_url ?>mision/guardar" method="POST">
                                <div class="mb-3">
                                    <label class="form-label small fw-medium">Declaración de misión</label>
                                    <textarea name="mision" class="form-control" rows="5" 
                                              placeholder="Escribe la misión de tu organización..." required></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-minimal btn-primary-minimal w-100">
                                    <i class="fas fa-rocket me-2"></i>
                                    Crear Misión
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SIDEBAR MINIMALISTA -->
            <div class="col-lg-4">
                <!-- PROGRESO -->
                <div class="sidebar-card">
                    <h6 class="mb-3 d-flex align-items-center">
                        <i class="fas fa-chart-line me-2 text-primary"></i>
                        Progreso
                    </h6>
                    
                    <div class="progress-minimal mb-2">
                        <div class="progress-fill-minimal" style="width: <?= ($misiones && $misiones->num_rows > 0) ? '25%' : '0%' ?>"></div>
                    </div>
                    
                    <p class="small text-muted mb-0">
                        <?= ($misiones && $misiones->num_rows > 0) ? '1 de 4 completados' : '0 de 4 completados' ?>
                    </p>
                </div>

                <!-- GUÍA -->
                <div class="sidebar-card">
                    <h6 class="mb-3 d-flex align-items-center">
                        <i class="fas fa-lightbulb me-2 text-warning"></i>
                        ¿Qué es la Misión?
                    </h6>
                    
                    <p class="small text-muted mb-3">
                        La <strong>misión</strong> es la razón de ser de tu empresa. 
                        Define qué haces, por qué y para quién.
                    </p>
                    
                    <div class="small">
                        <div class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <span class="text-muted">Clara y concisa</span>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <span class="text-muted">Orientada al cliente</span>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <span class="text-muted">Propósito fundamental</span>
                        </div>
                    </div>
                </div>

                <!-- EJEMPLOS -->
                <div class="sidebar-card">
                    <h6 class="mb-3 d-flex align-items-center">
                        <i class="fas fa-star me-2 text-info"></i>
                        Ejemplos
                    </h6>
                    
                    <div class="small">
                        <div class="border-start border-primary border-3 ps-3 mb-3">
                            <div class="fw-medium mb-1">Servicios</div>
                            <div class="text-muted">Gestión que contribuye a la calidad de vida</div>
                        </div>
                        
                        <div class="border-start border-success border-3 ps-3 mb-3">
                            <div class="fw-medium mb-1">Productora</div>
                            <div class="text-muted">Deleitar con el mejor producto natural</div>
                        </div>
                        
                        <div class="border-start border-info border-3 ps-3">
                            <div class="fw-medium mb-1">Certificación</div>
                            <div class="text-muted">Dar valor económico mediante gestión de calidad</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Validación simple del formulario
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const textarea = this.querySelector('textarea[name="mision"]');
                if (textarea && textarea.value.trim().length < 10) {
                    e.preventDefault();
                    alert('La misión debe tener al menos 10 caracteres.');
                    textarea.focus();
                }
            });
        });
    </script>
</body>
</html>