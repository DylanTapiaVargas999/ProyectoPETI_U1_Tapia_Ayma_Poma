<?php if (isset($_SESSION['error_came'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error_came'] ?></div>
    <?php unset($_SESSION['error_came']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['came_guardado'])): ?>
    <div class="alert alert-<?= $_SESSION['came_guardado'] === 'completado' ? 'success' : 'danger' ?>">
        <?= $_SESSION['came_guardado'] === 'completado' ? 'Acciones guardadas correctamente' : 'Error al guardar las acciones' ?>
    </div>
    <?php unset($_SESSION['came_guardado']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['came_eliminado'])): ?>
    <div class="alert alert-<?= $_SESSION['came_eliminado'] === 'completado' ? 'success' : 'danger' ?>">
        <?= $_SESSION['came_eliminado'] === 'completado' ? 'Elemento eliminado correctamente' : 'Error al eliminar el elemento' ?>
    </div>
    <?php unset($_SESSION['came_eliminado']); ?>
<?php endif; ?>

<h1>Matriz CAME</h1>

<form action="<?= base_url ?>came/guardar" method="POST">
    <div class="row">
        <!-- Tabla C: Corregir Debilidades -->
        <div class="col-md-6">
            <h3>C: Corregir Debilidades</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Debilidad</th>
                        <th>Acción Correctiva</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($debilidades && $debilidades->num_rows > 0): ?>
                        <?php $contador = 1; ?>
                        <?php while ($debilidad = $debilidades->fetch_object()): ?>
                            <tr>
                                <td><?= $contador++ ?></td>
                                <td><?= htmlspecialchars($debilidad->corregir) ?></td>
                                <td>
                                    <textarea name="debilidades[<?= $debilidad->id_corregir ?>]" 
                                              class="form-control" 
                                              rows="2"><?= htmlspecialchars($debilidad->corregir) ?></textarea>
                                </td>
                                <td>
                                    <a href="<?= base_url ?>came/eliminar?id=<?= $debilidad->id_corregir ?>&tipo=corregir" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('¿Estás seguro de eliminar esta debilidad?')">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay debilidades registradas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla A: Afrontar Amenazas -->
        <div class="col-md-6">
            <h3>A: Afrontar Amenazas</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Amenaza</th>
                        <th>Acción de Afrontamiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($amenazas && $amenazas->num_rows > 0): ?>
                        <?php $contador = 1; ?>
                        <?php while ($amenaza = $amenazas->fetch_object()): ?>
                            <tr>
                                <td><?= $contador++ ?></td>
                                <td><?= htmlspecialchars($amenaza->afrontar) ?></td>
                                <td>
                                    <textarea name="amenazas[<?= $amenaza->id_afrontar ?>]" 
                                              class="form-control" 
                                              rows="2"><?= htmlspecialchars($amenaza->afrontar) ?></textarea>
                                </td>
                                <td>
                                    <a href="<?= base_url ?>came/eliminar?id=<?= $amenaza->id_afrontar ?>&tipo=afrontar" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('¿Estás seguro de eliminar esta amenaza?')">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay amenazas registradas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Tabla M: Mantener Fortalezas -->
        <div class="col-md-6">
            <h3>M: Mantener Fortalezas</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fortaleza</th>
                        <th>Acción de Mantenimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($fortalezas && $fortalezas->num_rows > 0): ?>
                        <?php $contador = 1; ?>
                        <?php while ($fortaleza = $fortalezas->fetch_object()): ?>
                            <tr>
                                <td><?= $contador++ ?></td>
                                <td><?= htmlspecialchars($fortaleza->mantener) ?></td>
                                <td>
                                    <textarea name="fortalezas[<?= $fortaleza->id_mantener ?>]" 
                                              class="form-control" 
                                              rows="2"><?= htmlspecialchars($fortaleza->mantener) ?></textarea>
                                </td>
                                <td>
                                    <a href="<?= base_url ?>came/eliminar?id=<?= $fortaleza->id_mantener ?>&tipo=mantener" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('¿Estás seguro de eliminar esta fortaleza?')">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay fortalezas registradas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla E: Explotar Oportunidades -->
        <div class="col-md-6">
            <h3>E: Explotar Oportunidades</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Oportunidad</th>
                        <th>Acción de Explotación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($oportunidades && $oportunidades->num_rows > 0): ?>
                        <?php $contador = 1; ?>
                        <?php while ($oportunidad = $oportunidades->fetch_object()): ?>
                            <tr>
                                <td><?= $contador++ ?></td>
                                <td><?= htmlspecialchars($oportunidad->explotar) ?></td>
                                <td>
                                    <textarea name="oportunidades[<?= $oportunidad->id_explotar ?>]" 
                                              class="form-control" 
                                              rows="2"><?= htmlspecialchars($oportunidad->explotar) ?></textarea>
                                </td>
                                <td>
                                    <a href="<?= base_url ?>came/eliminar?id=<?= $oportunidad->id_explotar ?>&tipo=explotar" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('¿Estás seguro de eliminar esta oportunidad?')">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay oportunidades registradas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-lg">Guardar todas las acciones</button>
    </div>
</form>