<?php
if (isset($_SESSION['error_resumen'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error_resumen'] ?></div>
    <?php unset($_SESSION['error_resumen']); ?>
<?php endif; ?>

<div class="container mt-4">
    <h1 class="mb-4">Resumen del Plan Estratégico: <?= htmlspecialchars($_SESSION['plan_codigo']) ?></h1>

    <!-- Información del Usuario y Plan (Nueva Sección) -->
    <div class="card mb-4" style="max-width: 540px;">
      <div class="row g-0 align-items-center">
        <div class="col-md-4 text-center">
          <?php
            // Ajusta la ruta de la foto según tu estructura
            $foto = !empty($usuario->imagen) ? 'assets/img/perfiles/' . htmlspecialchars($usuario->imagen) : 'assets/img/default-user.png';
          ?>
          <img src="<?= base_url . $foto ?>" class="img-fluid rounded-circle m-3" alt="Foto de usuario" style="width:100px;height:100px;object-fit:cover;">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title mb-1"><?= htmlspecialchars($usuario->empresa) ?></h5>
            <p class="card-text mb-1">
              <strong>Fecha de creación del plan:</strong>
              <?= isset($plan->fecha) ? date('d/m/Y', strtotime($plan->fecha)) : '-' ?>
            </p>
            <p class="card-text">
              <small class="text-muted">Código del plan: <?= htmlspecialchars($codigo_plan) ?></small>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Misión -->
    <section class="card mb-4">
        <div class="card-header"><h2>Misión</h2></div>
        <div class="card-body">
            <?php if ($misiones && $misiones->num_rows > 0): ?>
                <?php while($mision = $misiones->fetch_object()): ?>
                    <p><?= nl2br(htmlspecialchars($mision->mision)) ?></p>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No hay misión definida.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Visión -->
    <section class="card mb-4">
        <div class="card-header"><h2>Visión</h2></div>
        <div class="card-body">
            <?php if ($visiones && $visiones->num_rows > 0): ?>
                <?php while($vision = $visiones->fetch_object()): ?>
                    <p><?= nl2br(htmlspecialchars($vision->vision)) ?></p>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No hay visión definida.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Valores -->
    <section class="card mb-4">
        <div class="card-header"><h2>Valores</h2></div>
        <div class="card-body">
            <?php if ($valores && $valores->num_rows > 0): ?>
                <ul class="list-group list-group-flush">
                <?php while($valor = $valores->fetch_object()): ?>
                    <li class="list-group-item"><?= htmlspecialchars($valor->valor) ?></li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">No hay valores definidos.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Unidades Estratégicas de Negocio (UENs) -->
    <section class="card mb-4">
        <div class="card-header"><h2>Unidades Estratégicas de Negocio (UENs)</h2></div>
        <div class="card-body">
            <?php if ($uenes && $uenes->num_rows > 0): ?>
                <ul class="list-group list-group-flush">
                <?php while($uen = $uenes->fetch_object()): ?>
                    <li class="list-group-item"><?= htmlspecialchars($uen->uen) ?></li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">No hay UENs definidas.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Objetivos Estratégicos -->
    <section class="card mb-4">
        <div class="card-header"><h2>Objetivos Estratégicos</h2></div>
        <div class="card-body">
            <?php if (!empty($objetivosGenerales)): ?>
                <?php foreach ($objetivosGenerales as $id_general => $general): ?>
                    <div class="mb-3">
                        <h5>Objetivo General: <?= htmlspecialchars($general['objetivo']) ?></h5>
                        <?php if (!empty($general['especificos'])): ?>
                            <ul class="list-group ms-3">
                            <?php foreach ($general['especificos'] as $especifico): ?>
                                <li class="list-group-item list-group-item-light">
                                    Objetivo Específico: <?= htmlspecialchars($especifico['objetivo']) ?>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted ms-3">No hay objetivos específicos para este objetivo general.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">No hay objetivos estratégicos definidos.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Análisis FODA -->
    <section class="card mb-4">
        <div class="card-header"><h2>Análisis FODA</h2></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Fortalezas</h4>
                    <?php if ($fortalezas && $fortalezas->num_rows > 0): mysqli_data_seek($fortalezas, 0); ?>
                        <ul class="list-group"><?php while($f = $fortalezas->fetch_object()): ?><li class="list-group-item"><?= htmlspecialchars($f->fortaleza) ?></li><?php endwhile; ?></ul>
                    <?php else: ?><p class="text-muted">No hay fortalezas definidas.</p><?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h4>Debilidades</h4>
                    <?php if ($debilidades && $debilidades->num_rows > 0): mysqli_data_seek($debilidades, 0); ?>
                        <ul class="list-group"><?php while($d = $debilidades->fetch_object()): ?><li class="list-group-item"><?= htmlspecialchars($d->debilidad) ?></li><?php endwhile; ?></ul>
                    <?php else: ?><p class="text-muted">No hay debilidades definidas.</p><?php endif; ?>
                </div>
            </div>
            <hr>
            <div class="row mt-3">
                <div class="col-md-6">
                    <h4>Oportunidades</h4>
                    <?php if ($oportunidades && $oportunidades->num_rows > 0): mysqli_data_seek($oportunidades, 0); ?>
                        <ul class="list-group"><?php while($o = $oportunidades->fetch_object()): ?><li class="list-group-item"><?= htmlspecialchars($o->oportunidad) ?></li><?php endwhile; ?></ul>
                    <?php else: ?><p class="text-muted">No hay oportunidades definidas.</p><?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h4>Amenazas</h4>
                    <?php if ($amenazas && $amenazas->num_rows > 0): mysqli_data_seek($amenazas, 0); ?>
                        <ul class="list-group"><?php while($a = $amenazas->fetch_object()): ?><li class="list-group-item"><?= htmlspecialchars($a->amenaza) ?></li><?php endwhile; ?></ul>
                    <?php else: ?><p class="text-muted">No hay amenazas definidas.</p><?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- IDENTIFICACIÓN DE ESTRATEGIA -->
    <section class="card mb-4">
        <div class="card-header bg-primary text-white"><h2>IDENTIFICACIÓN DE ESTRATEGIA</h2></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h4>Estrategia Recomendada:</h4>
                    <p class="lead" id="estrategia-recomendada">Complete el análisis FODA primero</p>
                    
                    <h5>Descripción:</h5>
                    <p id="descripcion-estrategia">Vaya a la sección de FODA y complete las matrices.</p>
                </div>
            </div>
            
            <div class="mt-3">
                <small class="text-muted">* Esta estrategia se basa en el análisis de las matrices FODA con mayor puntuación.</small>
            </div>
        </div>
    </section>

    <!-- Acciones Estratégicas (CAME) -->
    <section class="card mb-4">
        <div class="card-header"><h2>Acciones Estratégicas (CAME)</h2></div>
        <div class="card-body">
            <h4>Corregir (Debilidades)</h4>
            <?php if ($debilidades && $debilidades->num_rows > 0): mysqli_data_seek($debilidades, 0); ?>
                <ul class="list-group mb-3">
                <?php while($debilidad = $debilidades->fetch_object()): ?>
                    <li class="list-group-item">
                        <strong>Debilidad:</strong> <?= htmlspecialchars($debilidad->debilidad) ?>
                        <?php $accionCorregir = $corregirModel->obtenerPorDebilidadYUsuario($debilidad->id_debilidad, $id_usuario); ?>
                        <?php if ($accionCorregir && !empty($accionCorregir->corregir)): ?>
                            <p class="mb-0 mt-1"><em>Acción para Corregir:</em> <?= htmlspecialchars($accionCorregir->corregir) ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-0 mt-1"><em>No hay acción de corrección definida.</em></p>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">No hay debilidades para listar acciones de corrección.</p>
            <?php endif; ?>

            <h4>Afrontar (Amenazas)</h4>
            <?php if ($amenazas && $amenazas->num_rows > 0): mysqli_data_seek($amenazas, 0); ?>
                <ul class="list-group mb-3">
                <?php while($amenaza = $amenazas->fetch_object()): ?>
                    <li class="list-group-item">
                        <strong>Amenaza:</strong> <?= htmlspecialchars($amenaza->amenaza) ?>
                        <?php $accionAfrontar = $afrontarModel->obtenerPorAmenazaYUsuario($amenaza->id_amenaza, $id_usuario); ?>
                        <?php if ($accionAfrontar && !empty($accionAfrontar->afrontar)): ?>
                            <p class="mb-0 mt-1"><em>Acción para Afrontar:</em> <?= htmlspecialchars($accionAfrontar->afrontar) ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-0 mt-1"><em>No hay acción de afrontamiento definida.</em></p>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">No hay amenazas para listar acciones de afrontamiento.</p>
            <?php endif; ?>

            <h4>Mantener (Fortalezas)</h4>
            <?php if ($fortalezas && $fortalezas->num_rows > 0): mysqli_data_seek($fortalezas, 0); ?>
                <ul class="list-group mb-3">
                <?php while($fortaleza = $fortalezas->fetch_object()): ?>
                    <li class="list-group-item">
                        <strong>Fortaleza:</strong> <?= htmlspecialchars($fortaleza->fortaleza) ?>
                        <?php $accionMantener = $mantenerModel->obtenerPorFortalezaYUsuario($fortaleza->id_fortaleza, $id_usuario); ?>
                        <?php if ($accionMantener && !empty($accionMantener->mantener)): ?>
                            <p class="mb-0 mt-1"><em>Acción para Mantener:</em> <?= htmlspecialchars($accionMantener->mantener) ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-0 mt-1"><em>No hay acción de mantenimiento definida.</em></p>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">No hay fortalezas para listar acciones de mantenimiento.</p>
            <?php endif; ?>

            <h4>Explotar (Oportunidades)</h4>
            <?php if ($oportunidades && $oportunidades->num_rows > 0): mysqli_data_seek($oportunidades, 0); ?>
                <ul class="list-group">
                <?php while($oportunidad = $oportunidades->fetch_object()): ?>
                    <li class="list-group-item">
                        <strong>Oportunidad:</strong> <?= htmlspecialchars($oportunidad->oportunidad) ?>
                        <?php $accionExplotar = $explotarModel->obtenerPorOportunidadYUsuario($oportunidad->id_oportunidad, $id_usuario); ?>
                        <?php if ($accionExplotar && !empty($accionExplotar->explotar)): ?>
                            <p class="mb-0 mt-1"><em>Acción para Explotar:</em> <?= htmlspecialchars($accionExplotar->explotar) ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-0 mt-1"><em>No hay acción de explotación definida.</em></p>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">No hay oportunidades para listar acciones de explotación.</p>
            <?php endif; ?>
        </div>
    </section>

    <a href="<?= base_url ?>resumen/exportarPdf" class="btn btn-danger mb-3" target="_blank">
        <i class="fa fa-file-pdf"></i> Exportar a PDF
    </a>
</div>

<script>
function mostrarEstrategiaFODA() {
    // Obtener directamente de localStorage
    const tipo = localStorage.getItem('tipoEstrategiaFODA');
    const descripcion = localStorage.getItem('descripcionEstrategiaFODA');
    
    if (tipo && descripcion) {
        document.getElementById('estrategia-recomendada').textContent = tipo;
        document.getElementById('descripcion-estrategia').textContent = descripcion;
    } else {
        document.getElementById('estrategia-recomendada').textContent = 'Complete el análisis FODA primero';
        document.getElementById('descripcion-estrategia').textContent = 'Vaya a la sección de FODA y complete las matrices.';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    mostrarEstrategiaFODA();
});
</script>