
<div class="container">
    <h1 class="text-center my-4">Análisis Estratégico</h1>
    
    <!-- Mostrar mensajes de sesión -->
    <?php if (isset($_SESSION['error_analisis'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error_analisis']; unset($_SESSION['error_analisis']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['encuesta_guardada'])): ?>
        <div class="alert alert-<?= $_SESSION['encuesta_guardada'] == 'completado' ? 'success' : 'danger' ?>">
            Encuesta <?= $_SESSION['encuesta_guardada'] == 'completado' ? 'guardada' : 'no guardada' ?> correctamente
        </div>
        <?php unset($_SESSION['encuesta_guardada']); ?>
    <?php endif; ?>
    
    <!-- Mensajes similares para fortalezas y debilidades -->
    
    <div class="row">
        <!-- Sección de Encuesta -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>Encuesta de Cadena de Valor</h3>
                </div>
                <div class="card-body">
                    <?php if ($datos_encuesta): ?>
                        <div class="alert alert-info">
                            Ya has completado esta encuesta. Puedes editarla si lo deseas.
                        </div>
                        <a href="<?= base_url ?>analisis/index?editar_encuesta=<?= $datos_encuesta->id_encuesta_cadena ?>" class="btn btn-warning mb-3">Editar Encuesta</a>
                        
                        <!-- Mostrar resumen de la encuesta existente -->
                        <div class="mb-3">
                            <h5>Reflexión:</h5>
                            <p><?= htmlspecialchars($datos_encuesta->reflexion) ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?= base_url ?>analisis/guardarEncuesta" method="POST">
                        <input type="hidden" name="id_encuesta" value="<?= $edicion_encuesta ? $encuesta_actual->id_encuesta_cadena : '' ?>">
                        
                        <!-- Preguntas de la encuesta (simplificado) -->
<div class="row">
    <?php for ($i = 1; $i <= 25; $i++): ?>
        <div class="col-md-4 mb-3">
            <label for="p<?= $i ?>">Pregunta <?= $i ?>:</label>
            <select class="form-control pregunta" name="p<?= $i ?>" id="p<?= $i ?>">
                <?php for ($j = 0; $j <= 4; $j++): ?>
                    <option value="<?= $j ?>" 
                        <?= ($datos_encuesta && $datos_encuesta->{'p'.$i} == $j) ? 'selected' : '' ?>>
                        <?= $j ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
    <?php endfor; ?>
</div>

<!-- Campo para mostrar el resultado -->
<div class="form-group mt-3">
    <label for="resultado">Porcentaje: </label>
    <input type="text" class="form-control" id="resultado" readonly>
</div>

<script>
    function calcularPorcentaje() {
        let sumaTotal = 0;

        // Sumar todas las respuestas seleccionadas
        document.querySelectorAll('.pregunta').forEach(select => {
            sumaTotal += parseInt(select.value);
        });

        // Aplicar la fórmula: ((100 - sumaTotal) / 100) * 100
        let porcentaje = ((100 - sumaTotal) / 100) * 100;

        // Asegurar que el porcentaje no sea negativo
        if (porcentaje < 0) porcentaje = 0;

        // Mostrar resultado con 2 decimales
        document.getElementById('resultado').value = porcentaje.toFixed(2) + '%';
    }

    // Ejecutar al cargar la página y cuando se cambie una respuesta
    document.addEventListener('DOMContentLoaded', () => {
        calcularPorcentaje();

        // Añadir eventos a los selects dinámicamente después de que el DOM cargue
        document.querySelectorAll('.pregunta').forEach(select => {
            select.addEventListener('change', calcularPorcentaje);
        });
    });
</script>


                        
                        
                        <div class="form-group">
                            <label for="reflexion">Reflexión:</label>
                            <textarea class="form-control" name="reflexion" id="reflexion" rows="5"><?= $edicion_encuesta ? htmlspecialchars($encuesta_actual->reflexion) : '' ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <?= $edicion_encuesta ? 'Actualizar Encuesta' : 'Guardar Encuesta' ?>
                        </button>
                        
                        <?php if ($edicion_encuesta): ?>
                            <a href="<?= base_url ?>analisis/index" class="btn btn-secondary">Cancelar</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sección de Fortalezas -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3>Fortalezas</h3>
                </div>
                <div class="card-body">
                    <?php if ($fortalezas && $fortalezas->num_rows > 0): ?>
    <ul class="list-group mb-3">
        <?php while ($f = $fortalezas->fetch_object()): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($f->fortaleza) ?>
                                    <div>
                                        <a href="<?= base_url ?>analisis/index?editar_fortaleza=<?= $f->id_fortaleza ?>" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="<?= base_url ?>analisis/eliminarFortaleza?id=<?= $f->id_fortaleza ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                                    </div>
                                </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No hay fortalezas registradas aún.</p>
<?php endif; ?>
                    
                    <form action="<?= base_url ?>analisis/guardarFortaleza" method="POST">
                        <input type="hidden" name="id_fortaleza" value="<?= $edicion_fortaleza ? $fortaleza_actual->id_fortaleza : '' ?>">
                        
                        <div class="form-group">
                            <label for="fortaleza">Nueva Fortaleza:</label>
                            <input type="text" class="form-control" name="fortaleza" id="fortaleza" 
                                   value="<?= $edicion_fortaleza ? htmlspecialchars($fortaleza_actual->fortaleza) : '' ?>" required>
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <?= $edicion_fortaleza ? 'Actualizar Fortaleza' : 'Agregar Fortaleza' ?>
                        </button>
                        
                        <?php if ($edicion_fortaleza): ?>
                            <a href="<?= base_url ?>analisis/index" class="btn btn-secondary">Cancelar</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sección de Debilidades -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3>Debilidades</h3>
                </div>
                <div class="card-body">
                    <?php if ($debilidades && $debilidades->num_rows > 0): ?>
                        <ul class="list-group mb-3">
                            <?php while ($d = $debilidades->fetch_object()): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($d->debilidad) ?>
                                    <div>
                                        <a href="<?= base_url ?>analisis/index?editar_debilidad=<?= $d->id_debilidad ?>" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="<?= base_url ?>analisis/eliminarDebilidad?id=<?= $d->id_debilidad ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p>No hay debilidades registradas aún.</p>
                    <?php endif; ?>
                    
                    <form action="<?= base_url ?>analisis/guardarDebilidad" method="POST">
                        <input type="hidden" name="id_debilidad" value="<?= $edicion_debilidad ? $debilidad_actual->id_debilidad : '' ?>">
                        
                        <div class="form-group">
                            <label for="debilidad">Nueva Debilidad:</label>
                            <input type="text" class="form-control" name="debilidad" id="debilidad" 
                                   value="<?= $edicion_debilidad ? htmlspecialchars($debilidad_actual->debilidad) : '' ?>" required>
                        </div>
                        
                        <button type="submit" class="btn btn-danger">
                            <?= $edicion_debilidad ? 'Actualizar Debilidad' : 'Agregar Debilidad' ?>
                        </button>
                        
                        <?php if ($edicion_debilidad): ?>
                            <a href="<?= base_url ?>analisis/index" class="btn btn-secondary">Cancelar</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

