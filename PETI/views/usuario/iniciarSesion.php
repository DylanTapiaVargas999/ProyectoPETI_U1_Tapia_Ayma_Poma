<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso | Plan Estratégico Corporativo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url?>assets/css/usuario/iniciarSesion.css">
    <style>
        .auth-card::before {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            border-radius: 2px;
            background: var(--color-acento);
            margin: 0 auto 18px auto;
        }
    </style>
</head>
<body>
    <main class="main-auth">
        <section class="auth-card">
            <header class="auth-header">
                <img src="<?=base_url?>assets/img/logo.png" alt="Logo" class="logo-corporativo">
                <div>
                    <h1 class="nombre-sistema">Plan Estratégico Corporativo</h1>
                    <p class="subtitulo-sistema">Gestión y seguimiento de la estrategia empresarial</p>
                </div>
            </header>
            <div class="auth-tabs">
                <button id="btn-mostrar-login" class="tab-btn active" type="button">Iniciar Sesión</button>
                <button id="btn-mostrar-registro" class="tab-btn" type="button">Registro</button>
            </div>
            <div class="auth-forms">
                <!-- Login -->
                <form action="<?=base_url?>usuario/iniciarSesion" method="POST" id="form-login" class="auth-form">
                    <h2>Bienvenido</h2>
                    <p class="mensaje-bienvenida">Accede a tu panel de estrategia corporativa</p>
                    <?php if(isset($_SESSION['error_login'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error_login'] ?>
                        </div>
                        <?php unset($_SESSION['error_login']); ?>
                    <?php endif; ?>
                    <div class="grupo-formulario">
                        <label for="correo-login">Correo Electrónico</label>
                        <input type="email" name="correo-login" id="correo-login" required autocomplete="username">
                    </div>
                    <div class="grupo-formulario">
                        <label for="clave">Contraseña</label>
                        <div class="password-container">
                            <input type="password" name="clave" id="clave" required autocomplete="current-password">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('clave')"></i>
                        </div>
                    </div>
                    <div class="remember-forgot">
                        <label class="remember-me">
                            <input type="checkbox" name="remember"> Recordarme
                        </label>
                        <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                    </div>
                    <button type="submit" class="boton"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</button>
                </form>
                <!-- Registro -->
                <form action="<?=base_url?>usuario/guardar" method="POST" enctype="multipart/form-data" id="form-registro" class="auth-form oculto">
                    <h2>Crear cuenta</h2>
                    <p class="mensaje-bienvenida">Registra tu empresa para comenzar</p>
                    <?php if(isset($_SESSION['error_registro'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error_registro'] ?>
                        </div>
                        <?php unset($_SESSION['error_registro']); ?>
                    <?php endif; ?>
                    <div class="grupo-formulario">
                        <label for="empresa-registro">Empresa</label>
                        <input type="text" name="empresa-registro" id="empresa-registro" required>
                    </div>
                    <div class="grupo-formulario">
                        <label for="correo-registro">Correo Electrónico</label>
                        <input type="email" name="correo-registro" id="correo-registro" required autocomplete="username">
                    </div>
                    <div class="grupo-formulario">
                        <label for="clave-registro">Contraseña</label>
                        <div class="password-container">
                            <input type="password" name="clave-registro" id="clave-registro" required autocomplete="new-password">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('clave-registro')"></i>
                        </div>
                        <div class="password-strength" id="strength-indicator"></div>
                    </div>
                    <div class="grupo-formulario">
                        <label for="confirmar-clave-registro">Confirmar Contraseña</label>
                        <div class="password-container">
                            <input type="password" name="confirmar-clave-registro" id="confirmar-clave-registro" required autocomplete="new-password">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('confirmar-clave-registro')"></i>
                        </div>
                    </div>
                    <div class="terms-conditions">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">Acepto los <a href="#">Términos y Condiciones</a></label>
                    </div>
                    <button type="submit" class="boton"><i class="fas fa-user-plus"></i> Registrarse</button>
                </form>
            </div>
        </section>
    </main>
    <script src="<?=base_url?>assets/css/usuario/iniciarSesion.js"></script>
</body>
</html>
