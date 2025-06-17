<?php
?>
<!-- filepath: c:\xampp\htdocs\PETI\views\resumen\pdf.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen del Plan Estratégico</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1, h2, h3 { color: #333; }
        .card { border:1px solid #ccc; border-radius:8px; margin-bottom:20px; padding:10px; }
        .card-header { font-weight:bold; font-size:16px; margin-bottom:8px; }
        .list-group { margin:0; padding-left:20px; }
        .list-group-item { margin-bottom:3px; }
        .text-muted { color: #888; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mb-3 { margin-bottom: 1rem; }
        .ms-3 { margin-left: 1rem; }
        .foto-perfil { width:80px; height:80px; border-radius:50%; object-fit:cover; border:2px solid #aaa; }
        .info-empresa { margin-bottom: 20px; }
    </style>
</head>
<body>

<h1 class="mb-4">Resumen del Plan Estratégico</h1>

<!-- Información del Usuario y Plan -->
<div class="card mb-4 info-empresa">
    <table>
        <tr>
            <td style="vertical-align:top;">
                <?php
                $foto = !empty($usuario->imagen) ? 'assets/img/perfiles/' . htmlspecialchars($usuario->imagen) : 'assets/img/default-user.png';
                ?>
                <img src="<?= $foto ?>" class="foto-perfil" alt="Foto de usuario">
            </td>
            <td style="padding-left:20px;">
                <strong>Empresa:</strong> <?= htmlspecialchars($usuario->empresa) ?><br>
                <strong>Fecha de creación:</strong> <?= isset($plan->fecha) ? date('d/m/Y', strtotime($plan->fecha)) : '-' ?><br>
                <strong>Código del plan:</strong> <?= htmlspecialchars($plan->codigo) ?>
            </td>
        </tr>
    </table>
</div>

<!-- Misión -->
<section class="card mb-4">
    <div class="card-header"><h2>Misión</h2></div>
    <div class="card-body">
        <?php if (isset($misiones) && $misiones && $misiones->num_rows > 0): ?>
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
        <?php if (isset($visiones) && $visiones && $visiones->num_rows > 0): ?>
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
        <?php if (isset($valores) && $valores && $valores->num_rows > 0): ?>
            <ul class="list-group">
                <?php while($valor = $valores->fetch_object()): ?>
                    <li class="list-group-item"><?= htmlspecialchars($valor->valor) ?></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">No hay valores definidos.</p>
        <?php endif; ?>
    </div>
</section>

<!-- UENs -->
<section class="card mb-4">
    <div class="card-header"><h2>Unidades Estratégicas de Negocio (UENs)</h2></div>
    <div class="card-body">
        <?php if (isset($uenes) && $uenes && $uenes->num_rows > 0): ?>
            <ul class="list-group">
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
        <?php if (isset($objetivosGenerales) && !empty($objetivosGenerales)): ?>
            <?php foreach ($objetivosGenerales as $id_general => $general): ?>
                <div class="mb-3">
                    <strong>Objetivo General:</strong> <?= htmlspecialchars($general['objetivo']) ?><br>
                    <?php if (!empty($general['especificos'])): ?>
                        <ul class="list-group ms-3">
                        <?php foreach ($general['especificos'] as $especifico): ?>
                            <li class="list-group-item">
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
        <div>
            <strong>Fortalezas:</strong>
            <?php if (isset($fortalezas) && $fortalezas && $fortalezas->num_rows > 0): ?>
                <ul class="list-group">
                    <?php while($f = $fortalezas->fetch_object()): ?>
                        <li class="list-group-item"><?= htmlspecialchars($f->fortaleza) ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <span class="text-muted">No hay fortalezas definidas.</span>
            <?php endif; ?>
        </div>
        <div>
            <strong>Debilidades:</strong>
            <?php if (isset($debilidades) && $debilidades && $debilidades->num_rows > 0): ?>
                <ul class="list-group">
                    <?php while($d = $debilidades->fetch_object()): ?>
                        <li class="list-group-item"><?= htmlspecialchars($d->debilidad) ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <span class="text-muted">No hay debilidades definidas.</span>
            <?php endif; ?>
        </div>
        <div>
            <strong>Oportunidades:</strong>
            <?php if (isset($oportunidades) && $oportunidades && $oportunidades->num_rows > 0): ?>
                <ul class="list-group">
                    <?php while($o = $oportunidades->fetch_object()): ?>
                        <li class="list-group-item"><?= htmlspecialchars($o->oportunidad) ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <span class="text-muted">No hay oportunidades definidas.</span>
            <?php endif; ?>
        </div>
        <div>
            <strong>Amenazas:</strong>
            <?php if (isset($amenazas) && $amenazas && $amenazas->num_rows > 0): ?>
                <ul class="list-group">
                    <?php while($a = $amenazas->fetch_object()): ?>
                        <li class="list-group-item"><?= htmlspecialchars($a->amenaza) ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <span class="text-muted">No hay amenazas definidas.</span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- IDENTIFICACIÓN DE ESTRATEGIA -->
<section class="card mb-4">
    <div class="card-header"><h2>IDENTIFICACIÓN DE ESTRATEGIA</h2></div>
    <div class="card-body">
        <div>
            <strong>Estrategia Recomendada:</strong>
            <span id="estrategia-pdf">Complete el análisis FODA primero</span>
        </div>
        <br>
        <div>
            <strong>Descripción:</strong>
            <span id="descripcion-pdf">Vaya a la sección de FODA y complete las matrices.</span>
        </div>
        <br>
        <div>
            <small class="text-muted">* Esta estrategia se basa en el análisis de las matrices FODA con mayor puntuación.</small>
        </div>
    </div>
</section>

<script>
// Obtener datos de localStorage para el PDF
document.addEventListener('DOMContentLoaded', function() {
    const tipo = localStorage.getItem('tipoEstrategiaFODA');
    const descripcion = localStorage.getItem('descripcionEstrategiaFODA');
    
    if (tipo && descripcion) {
        document.getElementById('estrategia-pdf').textContent = tipo;
        document.getElementById('descripcion-pdf').textContent = descripcion;
    }
});
</script>

<!-- Acciones Estratégicas (CAME) -->
<section class="card mb-4">
    <div class="card-header"><h2>Acciones Estratégicas (CAME)</h2></div>
    <div class="card-body">
        <div>
            <strong>Corregir (Debilidades):</strong>
            <?php if (isset($debilidades) && $debilidades && $debilidades->num_rows > 0): ?>
                <ul class="list-group">
                    <?php while($debilidad = $debilidades->fetch_object()): ?>
                        <li class="list-group-item">
                            <strong>Debilidad:</strong> <?= htmlspecialchars($debilidad->debilidad) ?>
                            <?php $accionCorregir = $corregirModel->obtenerPorDebilidadYUsuario($debilidad->id_debilidad, $id_usuario); ?>
                            <?php if ($accionCorregir && !empty($accionCorregir->corregir)): ?>
                                <br><em>Acción para Corregir:</em> <?= htmlspecialchars($accionCorregir->corregir) ?>
                            <?php else: ?>
                                <br><span class="text-muted"><em>No hay acción de corrección definida.</em></span>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <span class="text-muted">No hay debilidades para listar acciones de corrección.</span>
            <?php endif; ?>
        </div>
        <div>
            <strong>Afrontar (Amenazas):</strong>
            <?php if (isset($amenazas) && $amenazas && $amenazas->num_rows > 0): ?>
                <ul class="list-group">
                    <?php while($amenaza = $amenazas->fetch_object()): ?>
                        <li class="list-group-item">
                            <strong>Amenaza:</strong> <?= htmlspecialchars($amenaza->amenaza) ?>
                            <?php $accionAfrontar = $afrontarModel->obtenerPorAmenazaYUsuario($amenaza->id_amenaza, $id_usuario); ?>
                            <?php if ($accionAfrontar && !empty($accionAfrontar->afrontar)): ?>
                                <br><em>Acción para Afrontar:</em> <?= htmlspecialchars($accionAfrontar->afrontar) ?>
                            <?php else: ?>
                                <br><span class="text-muted"><em>No hay acción de afrontamiento definida.</em></span>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <span class="text-muted">No hay amenazas para listar acciones de afrontamiento.</span>
            <?php endif; ?>
        </div>
        <div>
            <strong>Mantener (Fortalezas):</strong>
            <?php if (isset($fortalezas) && $fortalezas && $fortalezas->num_rows > 0): ?>
                <ul class="list-group">
                    <?php while($fortaleza = $fortalezas->fetch_object()): ?>
                        <li class="list-group-item">
                            <strong>Fortaleza:</strong> <?= htmlspecialchars($fortaleza->fortaleza) ?>
                            <?php $accionMantener = $mantenerModel->obtenerPorFortalezaYUsuario($fortaleza->id_fortaleza, $id_usuario); ?>
                            <?php if ($accionMantener && !empty($accionMantener->mantener)): ?>
                                <br><em>Acción para Mantener:</em> <?= htmlspecialchars($accionMantener->mantener) ?>
                            <?php else: ?>
                                <br><span class="text-muted"><em>No hay acción de mantenimiento definida.</em></span>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <span class="text-muted">No hay fortalezas para listar acciones de mantenimiento.</span>
            <?php endif; ?>
        </div>
        <div>
            <strong>Explotar (Oportunidades):</strong>
            <?php if (isset($oportunidades) && $oportunidades && $oportunidades->num_rows > 0): ?>
                <ul class="list-group">
                    <?php while($oportunidad = $oportunidades->fetch_object()): ?>
                        <li class="list-group-item">
                            <strong>Oportunidad:</strong> <?= htmlspecialchars($oportunidad->oportunidad) ?>
                            <?php $accionExplotar = $explotarModel->obtenerPorOportunidadYUsuario($oportunidad->id_oportunidad, $id_usuario); ?>
                            <?php if ($accionExplotar && !empty($accionExplotar->explotar)): ?>
                                <br><em>Acción para Explotar:</em> <?= htmlspecialchars($accionExplotar->explotar) ?>
                            <?php else: ?>
                                <br><span class="text-muted"><em>No hay acción de explotación definida.</em></span>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <span class="text-muted">No hay oportunidades para listar acciones de explotación.</span>
            <?php endif; ?>
        </div>
    </div>
</section>

</body>
</html>