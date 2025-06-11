document.addEventListener('DOMContentLoaded', function() {
    // Alternar entre paneles
    const btnRegistro = document.getElementById('btn-mostrar-registro');
    const btnLogin = document.getElementById('btn-mostrar-login');
    const formRegistro = document.getElementById('form-registro');
    const formLogin = document.getElementById('form-login');

    if(btnRegistro && btnLogin && formRegistro && formLogin) {
        btnRegistro.addEventListener('click', function(e) {
            e.preventDefault();
            btnRegistro.classList.add('active');
            btnLogin.classList.remove('active');
            formRegistro.classList.remove('oculto');
            formLogin.classList.add('oculto');
        });

        btnLogin.addEventListener('click', function(e) {
            e.preventDefault();
            btnLogin.classList.add('active');
            btnRegistro.classList.remove('active');
            formLogin.classList.remove('oculto');
            formRegistro.classList.add('oculto');
        });
    }

    // Función para mostrar/ocultar contraseñas
    window.togglePassword = function(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling;
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Agregar la funcionalidad para la validación de la contraseña
    const passwordInput = document.getElementById('clave-registro');
    const confirmPasswordInput = document.getElementById('confirmar-clave-registro');
    const strengthIndicator = document.getElementById('strength-indicator');

    if (passwordInput && confirmPasswordInput && strengthIndicator) {
        passwordInput.addEventListener('input', function() {
            const strength = checkPasswordStrength(passwordInput.value);
            strengthIndicator.setAttribute('data-strength', strength);
        });

        confirmPasswordInput.addEventListener('input', function() {
            if (confirmPasswordInput.value !== passwordInput.value) {
                confirmPasswordInput.setCustomValidity("Las contraseñas no coinciden");
            } else {
                confirmPasswordInput.setCustomValidity("");
            }
        });
    }

    function checkPasswordStrength(password) {
        let strength = 'Débil';
        if (password.length >= 8 && /[A-Za-z]/.test(password) && /\d/.test(password)) {
            strength = 'Fuerte';
        } else if (password.length >= 6) {
            strength = 'Media';
        }
        return strength;
    }
});
