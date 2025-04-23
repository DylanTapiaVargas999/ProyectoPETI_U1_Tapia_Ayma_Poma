<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="<?=base_url?>assets/css/usuario/editarPerfil.css">
</head>
<body>
    <div class="contenedor-editar-perfil">
        <h1>Editar Perfil de <?= htmlspecialchars($usuario->nombre) ?></h1>
        
        <?php if (isset($_SESSION['perfil_actualizado'])): ?>
            <?php if ($_SESSION['perfil_actualizado'] == 'completado'): ?>
                <p class="mensaje-exito">Perfil actualizado con éxito.</p>
            <?php elseif ($_SESSION['perfil_actualizado'] == 'fallido'): ?>
                <p class="mensaje-error">Error al actualizar el perfil. Por favor, intente de nuevo.</p>
            <?php endif; ?>
            <?php unset($_SESSION['perfil_actualizado']); // Limpiar mensaje después de mostrar ?>
        <?php endif; ?>

        <form action="<?= base_url ?>usuario/actualizarPerfil" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($usuario->nombre) ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido">Representante legal:</label>
                <input type="text" name="apellido" id="apellido" value="<?= htmlspecialchars($usuario->apellido) ?>" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" name="correo" id="correo" value="<?= htmlspecialchars($usuario->correo) ?>" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen de Perfil:</label>
                <!-- Mostrar la imagen actual si existe -->
                <?php if (!empty($usuario->imagen)): ?>
                    <img src="<?= base_url ?>assets/img/perfiles/<?= htmlspecialchars($usuario->imagen) ?>" alt="Imagen actual de <?= htmlspecialchars($usuario->nombre) ?>" class="imagen-actual">
                <?php endif; ?>
                <input type="file" name="imagen" id="imagen" accept="image/*">
            </div>
            <div class="acciones-form">
                <input type="submit" value="Guardar Cambios">
                <a href="<?= base_url ?>usuario/perfil">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
