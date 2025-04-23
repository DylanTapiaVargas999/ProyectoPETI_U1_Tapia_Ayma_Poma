<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="<?=base_url?>assets/stylee.css">
</head>
<body>
    <div class="contenedor-perfil">
        <h1>Perfil de <?= htmlspecialchars($usuario->nombre) ?></h1>
        <div class="detalles-perfil">
            <!-- Mostrar la imagen de perfil si existe -->
            <?php if (!empty($usuario->imagen)): ?>
                <img src="<?=base_url?>assets/img/perfiles/<?= htmlspecialchars($usuario->imagen) ?>" alt="Imagen de perfil de <?= htmlspecialchars($usuario->nombre) ?>" class="imagen-perfil" width="5%" height="5%">
            <?php else: ?>
                <img src="<?=base_url?>assets/img/perfiles/default.png" alt="Imagen de perfil predeterminada" class="imagen-perfil" width="5%" height="5%">
            <?php endif; ?>

            <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario->nombre) ?></p>
            <p><strong>Representante legal:</strong> <?= htmlspecialchars($usuario->apellido) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario->correo) ?></p>
            <!-- Añade otros campos según tu tabla 'usuario' -->
        </div>
        <div class="acciones-perfil">
            <a href="<?=base_url?>usuario/editarPerfil">Editar Perfil</a>
            <a href="<?=base_url?>usuario/cerrarSesion">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>
