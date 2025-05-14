<head>
    <link rel="stylesheet" href="<?=base_url?>assets/css/valor/index.css">
</head>

<div class="valor-container">
    <h1>VALORES ORGANIZACIONALES</h1>

    <?php if (isset($_SESSION['valor_guardado'])): ?>
        <div class="alert <?= $_SESSION['valor_guardado'] == 'completado' ? 'alert-success' : 'alert-error' ?>">
            <?= $_SESSION['valor_guardado'] == 'completado' ? '✅ Valor guardado correctamente.' : '❌ Hubo un error al guardar el valor.' ?>
        </div>
        <?php unset($_SESSION['valor_guardado']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['valor_actualizado'])): ?>
        <div class="alert <?= $_SESSION['valor_actualizado'] == 'completado' ? 'alert-success' : 'alert-error' ?>">
            <?= $_SESSION['valor_actualizado'] == 'completado' ? '✅ Valor actualizado correctamente.' : '❌ Hubo un error al actualizar el valor.' ?>
        </div>
        <?php unset($_SESSION['valor_actualizado']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['valor_eliminado'])): ?>
        <div class="alert <?= $_SESSION['valor_eliminado'] == 'completado' ? 'alert-success' : 'alert-error' ?>">
            <?= $_SESSION['valor_eliminado'] == 'completado' ? '✅ Valor eliminado correctamente.' : '❌ Hubo un error al eliminar el valor.' ?>
        </div>
        <?php unset($_SESSION['valor_eliminado']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_valor'])): ?>
        <div class="alert alert-error">
            <?= $_SESSION['error_valor'] ?>
        </div>
        <?php unset($_SESSION['error_valor']); ?>
    <?php endif; ?>

    <p><strong>Los VALORES ORGANIZACIONALES</strong> son los principios fundamentales que guían el comportamiento de la organización.</p>

    <?php if (isset($edicion) && $edicion && isset($valorActual)): ?>
        <div class="editar-valor-container">
            <h2>Editar Valor</h2>
            <form action="<?= base_url ?>valor/guardar" method="POST">
                <input type="hidden" name="id_valor" value="<?= $valorActual->id_valor ?>">
                <textarea name="valor" required><?= htmlspecialchars($valorActual->valor) ?></textarea>
                <button type="submit">Guardar Cambios</button>
                <a href="<?= base_url ?>valor/index" class="btn-cancelar">Cancelar</a>
            </form>
        </div>
    <?php else: ?>
        <form action="<?= base_url ?>valor/guardar" method="POST">
            <textarea name="valor" placeholder="Escribe un valor organizacional..." required></textarea>
            <button type="submit">Agregar Valor</button>
        </form>
    <?php endif; ?>

    <div class="lista-valores">
        <h2>Valores Registrados</h2>
        <?php if ($valores && $valores->num_rows > 0): ?>
            <ul>
                <?php while($v = $valores->fetch_object()): ?>
                <li>
                    <?= htmlspecialchars($v->valor) ?>
                    <div class="acciones">
                        <a href="<?= base_url ?>valor/index&editar=<?= $v->id_valor ?>">Editar</a>
                        <a href="<?= base_url ?>valor/eliminar&id=<?= $v->id_valor ?>" onclick="return confirm('¿Eliminar este valor?')">Eliminar</a>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No hay valores registrados.</p>
        <?php endif; ?>
    </div>
</div>