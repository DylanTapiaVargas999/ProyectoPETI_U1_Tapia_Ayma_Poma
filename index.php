<?php
session_start();
ob_start();
require_once 'autoload.php';
require_once 'config/db.php';
require_once 'helpers/utils.php';
require_once 'config/parametros.php';

// Conexión a la base de datos
$db = Database::conexion();

function mostrar_error() {
    $error = new errorControlador();
    $error->index();
}

// Lógica para determinar el controlador y acción
if (isset($_GET['controlador'])) {
    $nombre_controlador = $_GET['controlador'] . 'Controlador';
} elseif (!isset($_GET['controlador']) && !isset($_GET['accion'])) {
    $nombre_controlador = controlador_predeterminado;
} else {
    mostrar_error();
    exit();
}

if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador;

    if (isset($_GET['accion']) && method_exists($controlador, $_GET['accion'])) {
        $accion = $_GET['accion'];
        ob_start();
        $controlador->$accion();
        $contenido = ob_get_clean();
    } elseif (!isset($_GET['controlador']) && !isset($_GET['accion'])) {
        $accion_predeterminada = accion_predeterminada;
        ob_start();
        $controlador->$accion_predeterminada();
        $contenido = ob_get_clean();
    } else {
        mostrar_error();
        exit();
    }
} else {
    mostrar_error();
    exit();
}

// Cargar layout con el contenido dinámico
require_once 'views/layout/layout.php';
