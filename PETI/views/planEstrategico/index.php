<head>
    <!-- Otros enlaces y metadatos -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- TU CSS PERSONALIZADO -->
    <link rel="stylesheet" href="<?=base_url?>assets/css/planEstrategico/index.css">
</head>

<?php if (isset($_SESSION['identity'])): ?>
    <div class="container mt-4">
        <h2 class="mb-4"><i class="fas fa-chess-board"></i> Planes Estratégicos</h2>

        <!-- Mensajes de sesión -->
        <?php if (isset($_SESSION['plan_guardado'])): ?>
            <div class="alert alert-<?= $_SESSION['plan_guardado'] == 'completado' ? 'success' : 'danger' ?>">
                <i class="fas fa-<?= $_SESSION['plan_guardado'] == 'completado' ? 'check-circle' : 'exclamation-triangle' ?>"></i>
                <?= $_SESSION['plan_guardado'] == 'completado' ? 'Plan guardado correctamente.' : 'Error al guardar el plan.' ?>
            </div>
            <?php unset($_SESSION['plan_guardado']); ?>
        <?php endif; ?>

        <!-- Sección de Acciones -->
        <div class="actions-section">
            <a href="<?= base_url ?>usuario/cerrarSesion" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i>
                Cerrar Sesión
            </a>
        </div>

        <!-- Formulario mejorado -->
        <div class="form-section">
            <h4><i class="fas fa-plus-circle"></i> <?= isset($planData) ? 'Editar Plan' : 'Crear Nuevo Plan' ?></h4>
            <form action="<?= base_url ?>planEstrategico/guardar" method="POST">
                <div class="form-group mb-3">
                    <label for="titulo"><i class="fas fa-tag"></i> Título del Plan</label>
                    <input type="text" name="titulo" class="form-control" value="<?= isset($planData) ? $planData->titulo : '' ?>" placeholder="Ingresa el título del plan estratégico" required>
                </div>

                <?php if (isset($planData)): ?>
                    <input type="hidden" name="id" value="<?= $planData->id ?>">
                    <input type="hidden" name="codigo" value="<?= $planData->codigo ?>">
                <?php endif; ?>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-<?= isset($planData) ? 'edit' : 'save' ?>"></i>
                    <?= isset($planData) ? 'Actualizar Plan' : 'Guardar Plan' ?>
                </button>
            </form>
        </div>

        <!-- Tabla mejorada -->
        <div class="table-section">
            <h4><i class="fas fa-list"></i> Listado de Planes</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-code"></i> Código</th>
                            <th><i class="fas fa-file-alt"></i> Título</th>
                            <th><i class="fas fa-calendar"></i> Fecha</th>
                            <th><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $plan = new PlanEstrategico();
                        $planes = $plan->obtenerTodosPorUsuario($_SESSION['identity']->id);
                        $hayPlanes = false;
                        while ($p = $planes->fetch_object()):
                            $hayPlanes = true;
                        ?>
                            <tr>
                                <td data-label="ID"><?= $p->id ?></td>
                                <td data-label="Código">
                                    <code style="background: var(--light-gray); padding: 0.25rem 0.5rem; border-radius: 4px; color: var(--primary-color); font-weight: 600;">
                                        <?= $p->codigo ?>
                                    </code>
                                </td>
                                <td data-label="Título">
                                    <strong><?= $p->titulo ?></strong>
                                </td>
                                <td data-label="Fecha">
                                    <?php if ($p->fecha): ?>
                                        <span class="badge-status badge-active">
                                            <i class="fas fa-calendar-check"></i>
                                            <?= date('d/m/Y', strtotime($p->fecha)) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-status badge-inactive">
                                            <i class="fas fa-calendar-times"></i>
                                            Sin fecha
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Acciones">
                                    <a href="<?= base_url ?>planEstrategico/editar&id=<?= $p->id ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="<?= base_url ?>planEstrategico/eliminar&id=<?= $p->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este plan?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </a>
                                    <a href="<?= base_url ?>planEstrategico/seleccionar&id=<?= $p->id ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-check-circle"></i> Seleccionar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        
                        <?php if (!$hayPlanes): ?>
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-clipboard-list"></i>
                                        <h4>No hay planes registrados</h4>
                                        <p>Crea tu primer plan estratégico para comenzar</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container mt-5">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            Debes iniciar sesión para ver esta sección.
        </div>
    </div>
<?php endif; ?>
