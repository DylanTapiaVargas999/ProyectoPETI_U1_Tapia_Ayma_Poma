<head>
    <link rel="stylesheet" href="<?= base_url ?>assets/css/foda/index.css">
    <!-- Agregar jQuery para las interacciones AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .matriz-container {
            margin: 20px 0;
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
            font-weight: bold;
        }
        .valor-select {
            width: 60px;
            padding: 5px;
        }
        .resultados-estrategicos {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .estrategia-principal {
            font-weight: bold;
            color: #2c3e50;
            font-size: 1.2em;
            margin-top: 10px;
        }
    </style>
</head>

<div class="foda-container">
    <h1>Análisis FODA</h1>

    <!-- Mensajes de sesión -->
    <?php foreach (['fortaleza', 'debilidad', 'oportunidad', 'amenaza'] as $tipo): ?>
        <?php if (isset($_SESSION["{$tipo}_guardada"])): ?>
            <div class="alert <?= $_SESSION["{$tipo}_guardada"] == 'completado' ? 'alert-success' : 'alert-error' ?>">
                <?= $_SESSION["{$tipo}_guardada"] == 'completado' ? "✅ $tipo guardada correctamente." : "❌ Error al guardar $tipo." ?>
            </div>
            <?php unset($_SESSION["{$tipo}_guardada"]); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION["{$tipo}_eliminada"])): ?>
            <div class="alert <?= $_SESSION["{$tipo}_eliminada"] == 'completado' ? 'alert-success' : 'alert-error' ?>">
                <?= $_SESSION["{$tipo}_eliminada"] == 'completado' ? "✅ $tipo eliminada correctamente." : "❌ Error al eliminar $tipo." ?>
            </div>
            <?php unset($_SESSION["{$tipo}_eliminada"]); ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- Mostrar mensajes de las matrices -->
    <?php if (isset($_SESSION['exito_foda'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito_foda'] ?></div>
        <?php unset($_SESSION['exito_foda']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_foda'])): ?>
        <div class="alert alert-error"><?= $_SESSION['error_foda'] ?></div>
        <?php unset($_SESSION['error_foda']); ?>
    <?php endif; ?>

    <!-- Elementos FODA básicos -->
    <div class="elementos-foda">
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

    <!-- Matrices de Evaluación Estratégica -->
    <div class="matrices-estrategicas">
        <h2>Matriz de Evaluación Estratégica</h2>
        
        <!-- Matriz FO - Fortalezas vs Oportunidades -->
        <div class="matriz-container">
            <h3>Fortalezas vs Oportunidades (Estrategia Ofensiva)</h3>
            <p>Las fortalezas se usan para tomar ventaja en cada una de las oportunidades.</p>
            <p>0=En total desacuerdo, 1= No está de acuerdo, 2= Esta de acuerdo, 3= Bastante de acuerdo y 4=En total acuerdo</p>
            
            <table class="matriz-table">
                <thead>
                    <tr>
                        <th>Fortaleza\Oportunidad</th>
                        <?php foreach ($oportunidades as $oportunidad): ?>
                            <th><?= htmlspecialchars($oportunidad->oportunidad) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fortalezas as $fortaleza): ?>
                        <tr>
                            <td><?= htmlspecialchars($fortaleza->fortaleza) ?></td>
                            <?php foreach ($oportunidades as $oportunidad): ?>
                                <td>
                                    <select class="valor-select valor-fo"
                                            name="fo[<?= $fortaleza->id ?>][<?= $oportunidad->id ?>]"
                                            data-fortaleza="<?= $fortaleza->id ?>"
                                            data-oportunidad="<?= $oportunidad->id ?>">
                                        <?php for ($i = 0; $i <= 4; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="suma-columnas">
                        <td><strong>Total</strong></td>
                        <?php foreach ($oportunidades as $oportunidad): ?>
                            <td class="suma-col"></td>
                        <?php endforeach; ?>
                        <td class="suma-final"><strong>0</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Matriz FA - Fortalezas vs Amenazas -->
        <div class="matriz-container">
            <h3>Fortalezas vs Amenazas (Estrategia Defensiva)</h3>
            <p>Las fortalezas evaden el efecto negativo de las amenazas.</p>
            <p>0=En total desacuerdo, 1= No está de acuerdo, 2= Esta de acuerdo, 3= Bastante de acuerdo y 4=En total acuerdo</p>
            
            <table class="matriz-table">
                <thead>
                    <tr>
                        <th>Fortaleza\Amenaza</th>
                        <?php foreach ($amenazas as $amenaza): ?>
                            <th><?= htmlspecialchars($amenaza->amenaza) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fortalezas as $fortaleza): ?>
                        <tr>
                            <td><?= htmlspecialchars($fortaleza->fortaleza) ?></td>
                            <?php foreach ($amenazas as $amenaza): ?>
                                <td>
                                    <select name="fa[<?= $fortaleza->id ?>][<?= $amenaza->id ?>]" class="valor-select valor-fa" 
                                            data-fortaleza="<?= $fortaleza->id ?>" 
                                            data-amenaza="<?= $amenaza->id ?>">
                                        <?php for ($i = 0; $i <= 4; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="suma-columnas">
                        <td><strong>Total</strong></td>
                        <?php foreach ($amenazas as $amenaza): ?>
                            <td class="suma-col"></td>
                        <?php endforeach; ?>
                        <td class="suma-final"><strong>0</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Matriz DO - Debilidades vs Oportunidades -->
        <div class="matriz-container">
            <h3>Debilidades vs Oportunidades (Estrategia de Reorientación)</h3>
            <p>Superamos las debilidades tomando ventaja de las oportunidades.</p>
            <p>0=En total desacuerdo, 1= No está de acuerdo, 2= Esta de acuerdo, 3= Bastante de acuerdo y 4=En total acuerdo</p>
            
            <table class="matriz-table">
                <thead>
                    <tr>
                        <th>Debilidad\Oportunidad</th>
                        <?php foreach ($oportunidades as $oportunidad): ?>
                            <th><?= htmlspecialchars($oportunidad->oportunidad) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($debilidades as $debilidad): ?>
                        <tr>
                            <td><?= htmlspecialchars($debilidad->debilidad) ?></td>
                            <?php foreach ($oportunidades as $oportunidad): ?>
                                <td>
                                    <select name="do[<?= $debilidad->id ?>][<?= $oportunidad->id ?>]" class="valor-select valor-do" 
                                            data-debilidad="<?= $debilidad->id ?>" 
                                            data-oportunidad="<?= $oportunidad->id ?>">
                                        <?php for ($i = 0; $i <= 4; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="suma-columnas">
                        <td><strong>Total</strong></td>
                        <?php foreach ($oportunidades as $oportunidad): ?>
                            <td class="suma-col"></td>
                        <?php endforeach; ?>
                        <td class="suma-final"><strong>0</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Matriz DA - Debilidades vs Amenazas -->
        <div class="matriz-container">
            <h3>Debilidades vs Amenazas (Estrategia de Supervivencia)</h3>
            <p>Las debilidades intensifican notablemente el efecto negativo de las amenazas.</p>
            <p>0=En total desacuerdo, 1= No está de acuerdo, 2= Esta de acuerdo, 3= Bastante de acuerdo y 4=En total acuerdo</p>
            
            <table class="matriz-table">
                <thead>
                    <tr>
                        <th>Debilidad\Amenaza</th>
                        <?php foreach ($amenazas as $amenaza): ?>
                            <th><?= htmlspecialchars($amenaza->amenaza) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($debilidades as $debilidad): ?>
                        <tr>
                            <td><?= htmlspecialchars($debilidad->debilidad) ?></td>
                            <?php foreach ($amenazas as $amenaza): ?>
                                <td>
                                    <select name="da[<?= $debilidad->id ?>][<?= $amenaza->id ?>]" class="valor-select valor-da" 
                                            data-debilidad="<?= $debilidad->id ?>" 
                                            data-amenaza="<?= $amenaza->id ?>">
                                        <?php for ($i = 0; $i <= 4; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="suma-columnas">
                        <td><strong>Total</strong></td>
                        <?php foreach ($amenazas as $amenaza): ?>
                            <td class="suma-col"></td>
                        <?php endforeach; ?>
                        <td class="suma-final"><strong>0</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Resultados Estratégicos -->
    <div class="resultados-estrategicos">
        <h3>Síntesis de Resultados</h3>
        <table class="matriz-table">
            <thead>
                <tr>
                    <th>Relaciones</th>
                    <th>Tipología de estrategia</th>
                    <th>Puntuación</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>FO</td>
                    <td>Estrategia Ofensiva</td>
                    <td id="totalFO"><?= $totalFO ?></td>
                    <td>Deberá adoptar estrategias de crecimiento</td>
                </tr>
                <tr>
                    <td>FA</td>
                    <td>Estrategia Defensiva</td>
                    <td id="totalFA"><?= $totalFA ?></td>
                    <td>La empresa está preparada para enfrentarse a las amenazas</td>
                </tr>
                <tr>
                    <td>DO</td>
                    <td>Estrategia de Reorientación</td>
                    <td id="totalDO"><?= $totalDO ?></td>
                    <td>La empresa no puede aprovechar las oportunidades porque carece de preparación adecuada</td>
                </tr>
                <tr>
                    <td>DA</td>
                    <td>Estrategia de Supervivencia</td>
                    <td id="totalDA"><?= $totalDA ?></td>
                    <td>Se enfrenta a amenazas externas sin las fortalezas necesarias para luchar con la competencia</td>
                </tr>
            </tbody>
        </table>
        
        <div class="estrategia-principal">
            La puntuación mayor le indica la estrategia que deberá llevar a cabo: 
            <span style="color: #e74c3c;"></span>
        </div>
    </div>

    <!-- Botón para guardar matrices -->
    <form action="<?= base_url ?>foda/guardarMatrices" method="POST">
        <!-- ...todas las tablas aquí... -->
        <button type="submit" class="btn btn-primary btn-lg">Guardar Matrices FODA</button>
    </form>
</div>

<!-- JavaScript para manejar las matrices -->
<script>
$(document).ready(function() {
    // Función para enviar los valores de las matrices
    function enviarValor(tipo, id1, id2, valor) {
        $.post("<?= base_url ?>foda/guardarRelacion", {
            tipo: tipo,
            id_elemento1: id1,
            id_elemento2: id2,
            valor: valor
        }, function(response) {
            // Puedes agregar notificación de éxito si lo deseas
        }).fail(function() {
            alert('Error al guardar el valor. Por favor intente nuevamente.');
        });
    }

    // Manejar cambios en FO
    $('.valor-fo').change(function() {
        var fortaleza = $(this).data('fortaleza');
        var oportunidad = $(this).data('oportunidad');
        var valor = $(this).val();
        enviarValor('FO', fortaleza, oportunidad, valor);
    });

    // Manejar cambios en FA
    $('.valor-fa').change(function() {
        var fortaleza = $(this).data('fortaleza');
        var amenaza = $(this).data('amenaza');
        var valor = $(this).val();
        enviarValor('FA', fortaleza, amenaza, valor);
    });

    // Manejar cambios en DO
    $('.valor-do').change(function() {
        var debilidad = $(this).data('debilidad');
        var oportunidad = $(this).data('oportunidad');
        var valor = $(this).val();
        enviarValor('DO', debilidad, oportunidad, valor);
    });

    // Manejar cambios en DA
    $('.valor-da').change(function() {
        var debilidad = $(this).data('debilidad');
        var amenaza = $(this).data('amenaza');
        var valor = $(this).val();
        enviarValor('DA', debilidad, amenaza, valor);
    });

    // Cargar valores existentes al cargar la página
    function cargarValoresExistentes() {
        $.getJSON("<?= base_url ?>foda/obtenerValoresMatrices", {codigo: "<?= $_SESSION['plan_codigo'] ?>"}, function(data) {
            // FO
            $.each(data.fo, function(index, item) {
                $('.valor-fo[data-fortaleza="'+item.id_fortaleza+'"][data-oportunidad="'+item.id_oportunidad+'"]').val(item.valor);
            });
            
            // FA
            $.each(data.fa, function(index, item) {
                $('.valor-fa[data-fortaleza="'+item.id_fortaleza+'"][data-amenaza="'+item.id_amenaza+'"]').val(item.valor);
            });
            
            // DO
            $.each(data.do, function(index, item) {
                $('.valor-do[data-debilidad="'+item.id_debilidad+'"][data-oportunidad="'+item.id_oportunidad+'"]').val(item.valor);
            });
            
            // DA
            $.each(data.da, function(index, item) {
                $('.valor-da[data-debilidad="'+item.id_debilidad+'"][data-amenaza="'+item.id_amenaza+'"]').val(item.valor);
            });
        });
    }

    // Función para sumar columnas de una matriz (corrigiendo el desfase)
    function sumarColumnasMatriz(selectorTabla) {
        var $tabla = $(selectorTabla);
        var filas = $tabla.find('tbody tr');
        var numCols = filas.first().find('td').length - 1; // Restar la columna de nombres
        var totalFinal = 0;
        for (var col = 1; col <= numCols; col++) { // Empieza en 1 para saltar la columna de nombres
            var suma = 0;
            filas.each(function() {
                var val = parseInt($(this).find('td').eq(col).find('select').val(), 10);
                if (!isNaN(val)) suma += val;
            });
            $tabla.find('tfoot .suma-col').eq(col - 1).text(suma); // col-1 porque suma-col no tiene la columna de nombres
            totalFinal += suma;
        }
        $tabla.find('tfoot .suma-final').html('<strong>' + totalFinal + '</strong>');
    }

    // Función para actualizar todas las sumas de columnas
    function actualizarSumas() {
        // FO
        sumarColumnasMatriz('.matriz-container:eq(0) .matriz-table');
        // FA
        sumarColumnasMatriz('.matriz-container:eq(1) .matriz-table');
        // DO
        sumarColumnasMatriz('.matriz-container:eq(2) .matriz-table');
        // DA
        sumarColumnasMatriz('.matriz-container:eq(3) .matriz-table');
        // Actualiza la tabla de resultados
        actualizarTotalesResultados();
    }

    function actualizarTotalesResultados() {
        // Obtén los totales finales de cada matriz
        var totalFO = parseInt($('.matriz-container:eq(0) .suma-final').text(), 10) || 0;
        var totalFA = parseInt($('.matriz-container:eq(1) .suma-final').text(), 10) || 0;
        var totalDO = parseInt($('.matriz-container:eq(2) .suma-final').text(), 10) || 0;
        var totalDA = parseInt($('.matriz-container:eq(3) .suma-final').text(), 10) || 0;

        // Actualiza la tabla de resultados
        $('#totalFO').text(totalFO);
        $('#totalFA').text(totalFA);
        $('#totalDO').text(totalDO);
        $('#totalDA').text(totalDA);

        // Determina la estrategia principal solo si hay algún total mayor a 0
        var max = Math.max(totalFO, totalFA, totalDO, totalDA);
        var estrategia = '';
        if (max > 0) {
            if (max === totalFO) estrategia = 'FO (Estrategia Ofensiva)';
            else if (max === totalFA) estrategia = 'FA (Estrategia Defensiva)';
            else if (max === totalDO) estrategia = 'DO (Estrategia de Reorientación)';
            else if (max === totalDA) estrategia = 'DA (Estrategia de Supervivencia)';
        }
        $('.estrategia-principal span').text(estrategia);
    }

    // Llama a actualizarSumas después de cargar valores y en cada cambio
    cargarValoresExistentes = (function(orig) {
        return function() {
            orig();
            setTimeout(actualizarSumas, 300); // Espera a que se llenen los selects
        };
    })(cargarValoresExistentes);

    $('.valor-select').change(function() {
        actualizarSumas();
    });

    // Inicializa sumas al cargar
    setTimeout(actualizarSumas, 500);

    cargarValoresExistentes();
});
</script>