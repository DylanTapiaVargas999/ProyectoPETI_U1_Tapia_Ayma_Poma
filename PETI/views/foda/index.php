<head>
    <link rel="stylesheet" href="<?= base_url ?>assets/css/foda/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .matriz-container {
            margin: 30px 0;
            overflow-x: auto;
        }
        .matriz-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .matriz-table th, .matriz-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .matriz-table th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
        }
        .matriz-table select {
            width: 60px;
            padding: 5px;
        }
        .total-cell {
            background-color: #e6f7ff;
            font-weight: bold;
        }
        .resumen-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        .resumen-table th, .resumen-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .resumen-table th {
            background-color: #f2f2f2;
        }
        .estrategia-principal {
            background-color: #e6ffed;
            font-weight: bold;
        }
        .alert {
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .btn-guardar {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-guardar:hover {
            background-color: #45a049;
        }
        .foda-section {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 5px;
        }
    </style>
</head>

<div class="foda-container">
    <h1>Análisis FODA</h1>

    <!-- Mensajes de sesión -->
    <?php foreach (['fortaleza', 'debilidad', 'oportunidad', 'amenaza'] as $tipo): ?>
        <?php if (isset($_SESSION["{$tipo}_guardada"])): ?>
            <div class="alert <?= $_SESSION["{$tipo}_guardada"] == 'completado' ? 'alert-success' : 'alert-error' ?>">
                <?= $_SESSION["{$tipo}_guardada"] == 'completado' ? "✅ " . ucfirst($tipo) . " guardada correctamente." : "❌ Error al guardar " . $tipo . "." ?>
            </div>
            <?php unset($_SESSION["{$tipo}_guardada"]); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION["{$tipo}_eliminada"])): ?>
            <div class="alert <?= $_SESSION["{$tipo}_eliminada"] == 'completado' ? 'alert-success' : 'alert-error' ?>">
                <?= $_SESSION["{$tipo}_eliminada"] == 'completado' ? "✅ " . ucfirst($tipo) . " eliminada correctamente." : "❌ Error al eliminar " . $tipo . "." ?>
            </div>
            <?php unset($_SESSION["{$tipo}_eliminada"]); ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if (isset($_SESSION['exito_foda'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['exito_foda'] ?>
        </div>
        <?php unset($_SESSION['exito_foda']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_foda'])): ?>
        <div class="alert alert-error">
            <?= $_SESSION['error_foda'] ?>
        </div>
        <?php unset($_SESSION['error_foda']); ?>
    <?php endif; ?>

    <!-- Elementos FODA -->
    <div class="foda-grid">
        <!-- FORTALEZAS -->
        <div class="foda-section">
            <h2>Fortalezas</h2>
            <?php if (!empty($fortalezas)): ?>
                <ul>
                    <?php foreach($fortalezas as $f): ?>
                        <li><?= htmlspecialchars($f->fortaleza) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay fortalezas registradas aún.</p>
            <?php endif; ?>
        </div>

        <!-- DEBILIDADES -->
        <div class="foda-section">
            <h2>Debilidades</h2>
            <?php if (!empty($debilidades)): ?>
                <ul>
                    <?php foreach($debilidades as $d): ?>
                        <li><?= htmlspecialchars($d->debilidad) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay debilidades registradas aún.</p>
            <?php endif; ?>
        </div>

        <!-- OPORTUNIDADES -->
        <div class="foda-section">
            <h2>Oportunidades</h2>
            <?php if (!empty($oportunidades)): ?>
                <ul>
                    <?php foreach($oportunidades as $o): ?>
                        <li><?= htmlspecialchars($o->oportunidad) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay oportunidades registradas aún.</p>
            <?php endif; ?>
        </div>

        <!-- AMENAZAS -->
        <div class="foda-section">
            <h2>Amenazas</h2>
            <?php if (!empty($amenazas)): ?>
                <ul>
                    <?php foreach($amenazas as $a): ?>
                        <li><?= htmlspecialchars($a->amenaza) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay amenazas registradas aún.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Formulario para guardar matrices -->
    <form action="<?= base_url ?>foda/guardarMatrices" method="POST">

        <!-- Matriz FO (Fortalezas - Oportunidades) -->
        <?php if (!empty($fortalezas) && !empty($oportunidades)): ?>
            <div class="matriz-container">
                <h2>Matriz FO (Fortalezas - Oportunidades)</h2>
                <table class="matriz-table">
                    <thead>
                        <tr>
                            <th>Fortaleza \ Oportunidad</th>
                            <?php foreach($oportunidades as $oportunidad): ?>
                                <th><?= htmlspecialchars($oportunidad->oportunidad) ?></th>
                            <?php endforeach; ?>
                            <th class="total-cell">Total Fila</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalFO = 0;
                        $columnTotalsFO = array_fill(0, count($oportunidades), 0);
                        ?>
                        <?php foreach($fortalezas as $fortaleza): ?>
                            <tr>
                                <th><?= htmlspecialchars($fortaleza->fortaleza) ?></th>
                                <?php 
                                $rowTotal = 0;
                                foreach($oportunidades as $index => $oportunidad): 
                                    $valor = 0;
                                    foreach($matrizFO as $relacion) {
                                        if (
                                            isset($relacion->id_fortaleza, $relacion->id_oportunidad, $relacion->id_matriz_fo) &&
                                            $relacion->id_fortaleza == $fortaleza->id_fortaleza &&
                                            $relacion->id_oportunidad == $oportunidad->id_oportunidad
                                        ) {
                                            $valor = $relacion->valor;
                                            break;
                                        }
                                    }
                                    $rowTotal += $valor;
                                    $columnTotalsFO[$index] += $valor;
                                ?>
                                    <td>
                                        <select name="matrizFO[<?= $fortaleza->id_fortaleza ?>][<?= $oportunidad->id_oportunidad ?>]">
                                            <?php for($i = 0; $i <= 4; $i++): ?>
                                                <option value="<?= $i ?>" <?= $valor == $i ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                <?php endforeach; ?>
                                <td class="total-cell"><?= $rowTotal ?></td>
                            </tr>
                        <?php 
                            $totalFO += $rowTotal;
                        endforeach; ?>
                        <tr>
                            <th class="total-cell">Total Columna</th>
                            <?php foreach($columnTotalsFO as $total): ?>
                                <td class="total-cell"><?= $total ?></td>
                            <?php endforeach; ?>
                            <td class="total-cell"><?= $totalFO ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="alert alert-error">No se puede mostrar la matriz FO. Se requieren fortalezas y oportunidades.</p>
        <?php endif; ?>

        <!-- Matriz FA (Fortalezas - Amenazas) -->
        <?php if (!empty($fortalezas) && !empty($amenazas)): ?>
            <div class="matriz-container">
                <h2>Matriz FA (Fortalezas - Amenazas)</h2>
                <table class="matriz-table">
                    <thead>
                        <tr>
                            <th>Fortaleza \ Amenaza</th>
                            <?php foreach($amenazas as $amenaza): ?>
                                <th><?= htmlspecialchars($amenaza->amenaza) ?></th>
                            <?php endforeach; ?>
                            <th class="total-cell">Total Fila</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalFA = 0;
                        $columnTotalsFA = array_fill(0, count($amenazas), 0);
                        ?>
                        <?php foreach($fortalezas as $fortaleza): ?>
                            <tr>
                                <th><?= htmlspecialchars($fortaleza->fortaleza) ?></th>
                                <?php 
                                $rowTotal = 0;
                                foreach($amenazas as $index => $amenaza): 
                                    $valor = 0;
                                    foreach($matrizFA as $relacion) {
                                        if (
                                            isset($relacion->id_fortaleza, $relacion->id_amenaza, $relacion->id_matriz_fa) &&
                                            $relacion->id_fortaleza == $fortaleza->id_fortaleza &&
                                            $relacion->id_amenaza == $amenaza->id_amenaza
                                        ) {
                                            $valor = $relacion->valor;
                                            break;
                                        }
                                    }
                                    $rowTotal += $valor;
                                    $columnTotalsFA[$index] += $valor;
                                ?>
                                    <td>
                                        <select name="matrizFA[<?= $fortaleza->id_fortaleza ?>][<?= $amenaza->id_amenaza ?>]">
                                            <?php for($i = 0; $i <= 4; $i++): ?>
                                                <option value="<?= $i ?>" <?= $valor == $i ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                <?php endforeach; ?>
                                <td class="total-cell"><?= $rowTotal ?></td>
                            </tr>
                        <?php 
                            $totalFA += $rowTotal;
                        endforeach; ?>
                        <tr>
                            <th class="total-cell">Total Columna</th>
                            <?php foreach($columnTotalsFA as $total): ?>
                                <td class="total-cell"><?= $total ?></td>
                            <?php endforeach; ?>
                            <td class="total-cell"><?= $totalFA ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="alert alert-error">No se puede mostrar la matriz FA. Se requieren fortalezas y amenazas.</p>
        <?php endif; ?>

        <!-- Matriz DO (Debilidades - Oportunidades) -->
        <?php if (!empty($debilidades) && !empty($oportunidades)): ?>
            <div class="matriz-container">
                <h2>Matriz DO (Debilidades - Oportunidades)</h2>
                <table class="matriz-table">
                    <thead>
                        <tr>
                            <th>Debilidad \ Oportunidad</th>
                            <?php foreach($oportunidades as $oportunidad): ?>
                                <th><?= htmlspecialchars($oportunidad->oportunidad) ?></th>
                            <?php endforeach; ?>
                            <th class="total-cell">Total Fila</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalDO = 0;
                        $columnTotalsDO = array_fill(0, count($oportunidades), 0);
                        ?>
                        <?php foreach($debilidades as $debilidad): ?>
                            <tr>
                                <th><?= htmlspecialchars($debilidad->debilidad) ?></th>
                                <?php 
                                $rowTotal = 0;
                                foreach($oportunidades as $index => $oportunidad): 
                                    $valor = 0;
                                    foreach($matrizDO as $relacion) {
                                        if (
                                            isset($relacion->id_debilidad, $relacion->id_oportunidad, $relacion->id_matriz_do) &&
                                            $relacion->id_debilidad == $debilidad->id_debilidad &&
                                            $relacion->id_oportunidad == $oportunidad->id_oportunidad
                                        ) {
                                            $valor = $relacion->valor;
                                            break;
                                        }
                                    }
                                    $rowTotal += $valor;
                                    $columnTotalsDO[$index] += $valor;
                                ?>
                                    <td>
                                        <select name="matrizDO[<?= $debilidad->id_debilidad ?>][<?= $oportunidad->id_oportunidad ?>]">
                                            <?php for($i = 0; $i <= 4; $i++): ?>
                                                <option value="<?= $i ?>" <?= $valor == $i ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                <?php endforeach; ?>
                                <td class="total-cell"><?= $rowTotal ?></td>
                            </tr>
                        <?php 
                            $totalDO += $rowTotal;
                        endforeach; ?>
                        <tr>
                            <th class="total-cell">Total Columna</th>
                            <?php foreach($columnTotalsDO as $total): ?>
                                <td class="total-cell"><?= $total ?></td>
                            <?php endforeach; ?>
                            <td class="total-cell"><?= $totalDO ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="alert alert-error">No se puede mostrar la matriz DO. Se requieren debilidades y oportunidades.</p>
        <?php endif; ?>

        <!-- Matriz DA (Debilidades - Amenazas) -->
        <?php if (!empty($debilidades) && !empty($amenazas)): ?>
            <div class="matriz-container">
                <h2>Matriz DA (Debilidades - Amenazas)</h2>
                <table class="matriz-table">
                    <thead>
                        <tr>
                            <th>Debilidad \ Amenaza</th>
                            <?php foreach($amenazas as $amenaza): ?>
                                <th><?= htmlspecialchars($amenaza->amenaza) ?></th>
                            <?php endforeach; ?>
                            <th class="total-cell">Total Fila</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalDA = 0;
                        $columnTotalsDA = array_fill(0, count($amenazas), 0);
                        ?>
                        <?php foreach($debilidades as $debilidad): ?>
                            <tr>
                                <th><?= htmlspecialchars($debilidad->debilidad) ?></th>
                                <?php 
                                $rowTotal = 0;
                                foreach($amenazas as $index => $amenaza): 
                                    $valor = 0;
                                    foreach($matrizDA as $relacion) {
                                        if (
                                            isset($relacion->id_debilidad, $relacion->id_amenaza, $relacion->id_matriz_da) &&
                                            $relacion->id_debilidad == $debilidad->id_debilidad &&
                                            $relacion->id_amenaza == $amenaza->id_amenaza
                                        ) {
                                            $valor = $relacion->valor;
                                            break;
                                        }
                                    }
                                    $rowTotal += $valor;
                                    $columnTotalsDA[$index] += $valor;
                                ?>
                                    <td>
                                        <select name="matrizDA[<?= $debilidad->id_debilidad ?>][<?= $amenaza->id_amenaza ?>]">
                                            <?php for($i = 0; $i <= 4; $i++): ?>
                                                <option value="<?= $i ?>" <?= $valor == $i ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                <?php endforeach; ?>
                                <td class="total-cell"><?= $rowTotal ?></td>
                            </tr>
                        <?php 
                            $totalDA += $rowTotal;
                        endforeach; ?>
                        <tr>
                            <th class="total-cell">Total Columna</th>
                            <?php foreach($columnTotalsDA as $total): ?>
                                <td class="total-cell"><?= $total ?></td>
                            <?php endforeach; ?>
                            <td class="total-cell"><?= $totalDA ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="alert alert-error">No se puede mostrar la matriz DA. Se requieren debilidades y amenazas.</p>
        <?php endif; ?>

        <!-- Resumen de estrategias -->
        <div class="resumen-container">
            <h2>Resumen de Estrategias</h2>
            <table class="resumen-table">
                <thead>
                    <tr>
                        <th>Matriz</th>
                        <th>Total</th>
                        <th>Tipo de Estrategia</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr <?= strpos($estrategiaPrincipal, 'FO') !== false ? 'class="estrategia-principal"' : '' ?>>
                        <td>FO (Fortalezas - Oportunidades)</td>
                        <td><?= $totalFO ?></td>
                        <td>Estrategia Ofensiva</td>
                        <td>Usar fortalezas para aprovechar oportunidades</td>
                    </tr>
                    <tr <?= strpos($estrategiaPrincipal, 'FA') !== false ? 'class="estrategia-principal"' : '' ?>>
                        <td>FA (Fortalezas - Amenazas)</td>
                        <td><?= $totalFA ?></td>
                        <td>Estrategia Defensiva</td>
                        <td>Usar fortalezas para evitar amenazas</td>
                    </tr>
                    <tr <?= strpos($estrategiaPrincipal, 'DO') !== false ? 'class="estrategia-principal"' : '' ?>>
                        <td>DO (Debilidades - Oportunidades)</td>
                        <td><?= $totalDO ?></td>
                        <td>Estrategia de Reorientación</td>
                        <td>Superar debilidades para aprovechar oportunidades</td>
                    </tr>
                    <tr <?= strpos($estrategiaPrincipal, 'DA') !== false ? 'class="estrategia-principal"' : '' ?>>
                        <td>DA (Debilidades - Amenazas)</td>
                        <td><?= $totalDA ?></td>
                        <td>Estrategia de Supervivencia</td>
                        <td>Minimizar debilidades y evitar amenazas</td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- Fin resumen-container -->

        <!-- Estrategia a usar -->
        <p id="estrategia-a-usar" style="text-align:center; margin-top:10px; font-weight:bold;">
            Estrategia a usar: 
            <span>
                <?php
                    $mayor = max($totalFO, $totalFA, $totalDO, $totalDA);
                    if ($mayor == $totalFO) echo 'FO (Fortalezas - Oportunidades)';
                    elseif ($mayor == $totalFA) echo 'FA (Fortalezas - Amenazas)';
                    elseif ($mayor == $totalDO) echo 'DO (Debilidades - Oportunidades)';
                    else echo 'DA (Debilidades - Amenazas)';
                ?>
            </span>
        </p>

        <!-- Botón de guardar -->
        <div class="form-actions">
            <button type="submit" class="btn-guardar">Guardar Matrices FODA</button>
        </div>
    </form>



<script>
// Variables globales
var tipoEstrategiaFODA = '';
var descripcionEstrategiaFODA = '';

$(document).ready(function() {
    $('.matriz-table select').change(function() {
        var table = $(this).closest('table');

        // Calcular total de fila
        table.find('tbody tr').each(function() {
            var rowTotal = 0;
            $(this).find('td select').each(function() {
                rowTotal += parseInt($(this).val()) || 0;
            });
            $(this).find('.total-cell').text(rowTotal);
        });

        // Calcular total de columna
        table.find('thead th').each(function(i) {
            if (i === 0 || $(this).hasClass('total-cell')) return;
            var colTotal = 0;
            table.find('tbody tr').not(':last').each(function() {
                var cell = $(this).find('td').eq(i - 1);
                if (cell.length && cell.find('select').length) {
                    colTotal += parseInt(cell.find('select').val()) || 0;
                }
            });
            table.find('tr:last td').eq(i - 1).text(colTotal);
        });

        // Calcular total general
        var generalTotal = 0;
        table.find('tr:not(:last) td.total-cell').each(function() {
            generalTotal += parseInt($(this).text()) || 0;
        });
        table.find('tr:last td.total-cell:last').text(generalTotal);

        // Actualizar resumen
        var matrizNombre = table.closest('.matriz-container').find('h2').text();
        var resumenRows = $('.resumen-table tbody tr');
        if (matrizNombre.includes('FO')) {
            resumenRows.eq(0).find('td').eq(1).text(generalTotal);
        } else if (matrizNombre.includes('FA')) {
            resumenRows.eq(1).find('td').eq(1).text(generalTotal);
        } else if (matrizNombre.includes('DO')) {
            resumenRows.eq(2).find('td').eq(1).text(generalTotal);
        } else if (matrizNombre.includes('DA')) {
            resumenRows.eq(3).find('td').eq(1).text(generalTotal);
        }

        // Actualizar estrategia a usar
        var totales = [
            {nombre: 'FO (Fortalezas - Oportunidades)', valor: parseInt(resumenRows.eq(0).find('td').eq(1).text()) || 0},
            {nombre: 'FA (Fortalezas - Amenazas)', valor: parseInt(resumenRows.eq(1).find('td').eq(1).text()) || 0},
            {nombre: 'DO (Debilidades - Oportunidades)', valor: parseInt(resumenRows.eq(2).find('td').eq(1).text()) || 0},
            {nombre: 'DA (Debilidades - Amenazas)', valor: parseInt(resumenRows.eq(3).find('td').eq(1).text()) || 0}
        ];
        var mayor = totales.reduce(function(prev, current) {
            return (prev.valor > current.valor) ? prev : current;
        });
        $('#estrategia-a-usar span').text(mayor.nombre);
    });

    // GUARDAR EN LOCALSTORAGE DESPUÉS DE HACER CLIC EN GUARDAR
    $('.btn-guardar').click(function(e) {
        // Identificar el mayor antes de guardar
        var resumenRows = $('.resumen-table tbody tr');
        var totales = [
            {matriz: 'FO', valor: parseInt(resumenRows.eq(0).find('td').eq(1).text()) || 0},
            {matriz: 'FA', valor: parseInt(resumenRows.eq(1).find('td').eq(1).text()) || 0},
            {matriz: 'DO', valor: parseInt(resumenRows.eq(2).find('td').eq(1).text()) || 0},
            {matriz: 'DA', valor: parseInt(resumenRows.eq(3).find('td').eq(1).text()) || 0}
        ];
        
        var mayorEstrategia = totales.reduce(function(prev, current) {
            return (prev.valor > current.valor) ? prev : current;
        });

        // Guardar tipo y descripción según la matriz ganadora
        if (mayorEstrategia.matriz === 'FO') {
            tipoEstrategiaFODA = 'Estrategia Ofensiva';
            descripcionEstrategiaFODA = 'Usar fortalezas para aprovechar oportunidades';
        } else if (mayorEstrategia.matriz === 'FA') {
            tipoEstrategiaFODA = 'Estrategia Defensiva';
            descripcionEstrategiaFODA = 'Usar fortalezas para evitar amenazas';
        } else if (mayorEstrategia.matriz === 'DO') {
            tipoEstrategiaFODA = 'Estrategia de Reorientación';
            descripcionEstrategiaFODA = 'Superar debilidades para aprovechar oportunidades';
        } else if (mayorEstrategia.matriz === 'DA') {
            tipoEstrategiaFODA = 'Estrategia de Supervivencia';
            descripcionEstrategiaFODA = 'Minimizar debilidades y evitar amenazas';
        }

        // GUARDAR EN LOCALSTORAGE
        localStorage.setItem('tipoEstrategiaFODA', tipoEstrategiaFODA);
        localStorage.setItem('descripcionEstrategiaFODA', descripcionEstrategiaFODA);
    });
});

// Funciones para acceder desde el resumen
function obtenerTipoEstrategia() {
    return localStorage.getItem('tipoEstrategiaFODA') || '';
}

function obtenerDescripcionEstrategia() {
    return localStorage.getItem('descripcionEstrategiaFODA') || '';
}
</script>