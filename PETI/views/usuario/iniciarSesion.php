<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Interactivo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url?>assets/css/usuario/login.css">
</head>
<body>

<section class="modal-autenticacion oculto" id="modal-auth">
  <div class="contenedor-auth" id="contenedor-auth">
    
    <!-- Panel Izquierdo (Login) -->
    <div class="panel-formulario panel-izquierdo" id="panel-login">
      <div class="formulario-box">
        <h3>Iniciar Sesión</h3>
        <form action="<?=base_url?>usuario/iniciarSesion" method="POST">
          <div class="grupo-formulario">
            <label for="correo-login">Correo Electrónico:</label>
            <input type="email" name="correo-login" id="correo-login" required>
          </div>
          <div class="grupo-formulario">
            <label for="clave">Contraseña:</label>
            <div class="password-container">
              <input type="password" name="clave" id="clave" required>
              <i class="fas fa-eye toggle-password" onclick="togglePassword('clave')"></i>
            </div>
          </div>
          <div class="remember-forgot">
            <label class="remember-me">
              <input type="checkbox" name="remember"> Recordarme
            </label>
            <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
          </div>
          <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
      </div>
    </div>

    <!-- Panel Derecho (Registro) -->
    <div class="panel-formulario panel-derecho" id="panel-registro">
      <div class="formulario-box">
        <h3>Registro</h3>
        <form action="<?=base_url?>usuario/guardar" method="POST">
          <div class="grupo-formulario">
            <label for="nombre-registro">Nombre:</label>
            <input type="text" name="nombre-registro" id="nombre-registro" required>
          </div>
          <div class="grupo-formulario">
            <label for="apellido-registro">Representante legal:</label>
            <input type="text" name="apellido-registro" id="apellido-registro" required>
          </div>
          <div class="grupo-formulario">
            <label for="correo-registro">Correo Electrónico:</label>
            <input type="email" name="correo-registro" id="correo-registro" required>
          </div>
          <div class="grupo-formulario">
            <label for="clave-registro">Contraseña:</label>
            <div class="password-container">
              <input type="password" name="clave-registro" id="clave-registro" required>
              <i class="fas fa-eye toggle-password" onclick="togglePassword('clave-registro')"></i>
            </div>
            <div class="password-strength" id="strength-indicator"></div>
          </div>
          <div class="grupo-formulario">
            <label for="confirmar-clave-registro">Confirmar Contraseña:</label>
            <div class="password-container">
              <input type="password" name="confirmar-clave-registro" id="confirmar-clave-registro" required>
              <i class="fas fa-eye toggle-password" onclick="togglePassword('confirmar-clave-registro')"></i>
            </div>
          </div>
          <div class="terms-conditions">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">Acepto los <a href="#">Términos y Condiciones</a></label>
          </div>
          <input type="submit" class="boton" value="Registrarse">
        </form>
      </div>
    </div>

    <!-- Controles para alternar -->
    <div class="controles-alternar">
      <button id="btn-mostrar-registro" class="boton-alternar">
        ¿No tienes cuenta? <span>Regístrate</span>
      </button>
      <button id="btn-mostrar-login" class="boton-alternar oculto">
        ¿Ya tienes cuenta? <span>Inicia Sesión</span>
      </button>
    </div>

    <!-- Botón cerrar -->
    <i class="cerrar fas fa-times-circle" onclick="cerrarModal()"></i>
  </div>
</section>

<script>
// Función para abrir el modal
function abrirModalLogin() {
    const modal = document.getElementById('modal-auth');
    modal.classList.remove('oculto');
    // Resetear al formulario de login al abrir
    document.getElementById('contenedor-auth').classList.remove('panel-registro-activo');
    document.getElementById('btn-mostrar-registro').classList.remove('oculto');
    document.getElementById('btn-mostrar-login').classList.add('oculto');
}

// Alternar entre paneles
document.addEventListener('DOMContentLoaded', function() {
    const contenedor = document.getElementById('contenedor-auth');
    const btnRegistro = document.getElementById('btn-mostrar-registro');
    const btnLogin = document.getElementById('btn-mostrar-login');
    
    btnRegistro.addEventListener('click', function(e) {
        e.preventDefault();
        contenedor.classList.add('panel-registro-activo');
        btnRegistro.classList.add('oculto');
        btnLogin.classList.remove('oculto');
    });
    
    btnLogin.addEventListener('click', function(e) {
        e.preventDefault();
        contenedor.classList.remove('panel-registro-activo');
        btnLogin.classList.add('oculto');
        btnRegistro.classList.remove('oculto');
    });
});

// Función para mostrar/ocultar contraseña
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const icon = document.querySelector(`#${fieldId} + .toggle-password`);
    
    if(passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Validación de fortaleza de contraseña
document.getElementById('clave-registro').addEventListener('input', function() {
    const password = this.value;
    const strengthIndicator = document.getElementById('strength-indicator');
    let strength = 0;
    
    if(password.length >= 8) strength++;
    if(password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
    if(password.match(/[0-9]/)) strength++;
    if(password.match(/[^a-zA-Z0-9]/)) strength++;
    
    strengthIndicator.className = 'password-strength strength-' + strength;
});

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('modal-auth').classList.add('oculto');
}
</script>

</body>
</html>