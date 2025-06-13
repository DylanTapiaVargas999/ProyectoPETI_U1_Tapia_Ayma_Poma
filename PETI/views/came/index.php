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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $modeloCorregir = new Corregir();
                    ?>
                    <?php if ($debilidades && $debilidades->num_rows > 0): ?>
                        <?php $contador = 1; ?>
                        <?php while ($debilidad = $debilidades->fetch_object()): ?>
                            <tr>
                                <td><?= $contador++ ?></td>
                                <td><?= htmlspecialchars($debilidad->debilidad) ?></td>
                                <td>
                                    <?php
                                    $accionGuardada = $modeloCorregir->obtenerPorDebilidadYUsuario($debilidad->id_debilidad, $_SESSION['identity']->id);
                                    $valor = $accionGuardada ? htmlspecialchars($accionGuardada->corregir) : '';
                                    ?>
                                    <textarea name="debilidades[<?= $debilidad->id_debilidad ?>]"
                                              class="form-control"
                                              rows="2"
                                              placeholder="Escribe cómo corregir esta debilidad"><?= $valor ?></textarea>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No hay debilidades registradas</td>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $modeloAfrontar = new Afrontar();
                    ?>
                    <?php if ($amenazas && $amenazas->num_rows > 0): ?>
                        <?php $contador = 1; ?>
                        <?php while ($amenaza = $amenazas->fetch_object()): ?>
                            <tr>
                                <td><?= $contador++ ?></td>
                                <td><?= htmlspecialchars($amenaza->amenaza) ?></td>
                                <td>
                                    <?php
                                    $accionGuardada = $modeloAfrontar->obtenerPorAmenazaYUsuario($amenaza->id_amenaza, $_SESSION['identity']->id);
                                    $valor = $accionGuardada ? htmlspecialchars($accionGuardada->afrontar) : '';
                                    ?>
                                    <textarea name="amenazas[<?= $amenaza->id_amenaza ?>]"
                                              class="form-control"
                                              rows="2"
                                              placeholder="Escribe cómo afrontar esta amenaza"><?= $valor ?></textarea>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No hay amenazas registradas</td>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $modeloMantener = new Mantener();
                    ?>
                    <?php if ($fortalezas && $fortalezas->num_rows > 0): ?>
                        <?php $contador = 1; ?>
                        <?php while ($fortaleza = $fortalezas->fetch_object()): ?>
                            <tr>
                                <td><?= $contador++ ?></td>
                                <td><?= htmlspecialchars($fortaleza->fortaleza) ?></td>
                                <td>
                                    <?php
                                    $accionGuardada = $modeloMantener->obtenerPorFortalezaYUsuario($fortaleza->id_fortaleza, $_SESSION['identity']->id);
                                    $valor = $accionGuardada ? htmlspecialchars($accionGuardada->mantener) : '';
                                    ?>
                                    <textarea name="fortalezas[<?= $fortaleza->id_fortaleza ?>]"
                                              class="form-control"
                                              rows="2"
                                              placeholder="Escribe cómo mantener esta fortaleza"><?= $valor ?></textarea>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No hay fortalezas registradas</td>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $modeloExplotar = new Explotar();
                    ?>
                    <?php if ($oportunidades && $oportunidades->num_rows > 0): ?>
                        <?php $contador = 1; ?>
                        <?php while ($oportunidad = $oportunidades->fetch_object()): ?>
                            <tr>
                                <td><?= $contador++ ?></td>
                                <td><?= htmlspecialchars($oportunidad->oportunidad) ?></td>
                                <td>
                                    <?php
                                    $accionGuardada = $modeloExplotar->obtenerPorOportunidadYUsuario($oportunidad->id_oportunidad, $_SESSION['identity']->id);
                                    $valor = $accionGuardada ? htmlspecialchars($accionGuardada->explotar) : '';
                                    ?>
                                    <textarea name="oportunidades[<?= $oportunidad->id_oportunidad ?>]"
                                              class="form-control"
                                              rows="2"
                                              placeholder="Escribe cómo explotar esta oportunidad"><?= $valor ?></textarea>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No hay oportunidades registradas</td>
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