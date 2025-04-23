$(document).ready(function() {
    $('.login').on('click', function() {
        if ($('.login').text().trim() == "Login") {
            $('.seccion-login').show();
        }
    });

    $('.cerrar').on('click', function() {
        $('.seccion-login').hide();
        $('.seccion-registro').hide();
    });

    $('.registrarse-aqui').on('click', function() {
        $('.seccion-login').hide();
        $('.seccion-registro').show();
    });

    $('.btn-registrarse').on('click', function() {
        $('.seccion-registro').hide();
    });

    $('.perfil-usuario').on('click', function(e){
        if($('.fa-user').hasClass('oculto') == false){
            $('.menu-hover-perfil').toggle();
        }
    })
});
