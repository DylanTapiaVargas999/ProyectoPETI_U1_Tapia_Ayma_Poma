<?php

class Utilidades {
    public static function eliminarSesion($nombre){
        if(isset($_SESSION[$nombre])){
            $_SESSION[$nombre] = null;
            unset($_SESSION[$nombre]);
        }

        return $nombre;
    }

    public static function esAdmin(){
        if(!isset($_SESSION['admin'])){
            header('Location: '.base_url);
        } else {
            return true;
        }
    }



    public static function estaLogueado(){
        if(!isset($_SESSION['identity'])){
            header("Location: ".base_url);
        } 
    }
}
