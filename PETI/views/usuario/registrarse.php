<!-- Modal de Registro -->
<?php if(isset($_SESSION['registro']) && $_SESSION['registro'] == 'completado'): ?>
    <h2 style="text-align:center;">¡Registro completado!</h2>
<?php elseif(isset($_SESSION['registro']) && $_SESSION['registro'] == 'fallido'): ?>
   <h2 style="text-align:center;">Error en el registro, ¡por favor ingresa los datos correctamente!</h2>
<?php endif; ?>

<?php Utilidades::eliminarSesion('registro'); ?>

<section class="seccion-registro oculto">
    <div class="contenedor-registro">
        <div class="caja-registro">
            <i class="cerrar fas fa-times-circle"></i>
            <div class="titulo-registro">
                <h3>Registro:</h3>
            </div>
            <form action="<?=base_url?>usuario/guardar" method="POST" class="formulario-registro">
                <div class="grupo-formulario-login">
                    <label for="nombre-registro">Nombre:</label>
                    <input type="text" name="nombre-registro" id="nombre-registro">
                </div>
                <div class="grupo-formulario-login">
                    <label for="apellido-registro">Representante legal:</label>
                    <input type="text" name="apellido-registro" id="apellido-registro">
                </div>
                <div class="grupo-formulario-login">
                    <label for="correo-registro">Correo Electrónico:</label>
                    <input type="email" name="correo-registro" id="correo-registro">
                </div>
                <div class="grupo-formulario-login">
                    <label for="clave-registro">Contraseña:</label>
                    <input type="password" name="clave-registro" id="clave-registro">
                </div>
                <div class="grupo-formulario-login">
                    <label for="confirmar-clave-registro">Confirmar Contraseña:</label>
                    <input type="password" name="confirmar-clave-registro" id="confirmar-clave-registro">
                </div>
                <div class="grupo-formulario-login">
                    <input type="submit" class="boton boton-registro" value="Registrarse">
                </div>
            </form>
        </div>
    </div>
</section>
