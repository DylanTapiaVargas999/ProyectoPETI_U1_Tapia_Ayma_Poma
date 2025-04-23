<?php
require_once 'models/uen.php';

class UenControlador {

    public function index() {
        // Redirigir directamente al tablero de objetivos
        header("Location:" . base_url . "objetivoGeneral/index");
        exit();
    }

    public function guardar() {
        if (isset($_POST) && isset($_SESSION['identity'])) {
            $textoUen = isset($_POST['uen']) ? $_POST['uen'] : null;

            if ($textoUen) {
                $nuevaUen = new Uen();
                $nuevaUen->setUen($textoUen);
                $nuevaUen->setIdUsuario($_SESSION['identity']->id);

                $guardado = $nuevaUen->guardar();

                $_SESSION['uen_guardada'] = $guardado ? 'completado' : 'fallido';
            } else {
                $_SESSION['uen_guardada'] = 'fallido';
            }
        }

        // Redirigir al tablero de objetivos
        header("Location:" . base_url . "objetivoGeneral/index");
        exit();
    }

    public function eliminar() {
        if (isset($_GET['id']) && isset($_SESSION['identity'])) {
            $id_uen = (int) $_GET['id'];
            $uen = new Uen();
            $uen->eliminar($id_uen);

            $_SESSION['uen_eliminada'] = 'completado';
        }

        // Redirigir al tablero de objetivos
        header("Location:" . base_url . "objetivoGeneral/index");
        exit();
    }

    public function editar() {
        if (isset($_GET['id']) && isset($_SESSION['identity'])) {
            $id_uen = (int) $_GET['id'];
            $id_usuario = $_SESSION['identity']->id;

            $uen = new Uen();
            $uenActual = $uen->obtenerPorId($id_uen, $id_usuario);

            if ($uenActual) {
                // Mostrar formulario de edición en modal (implementación en vista)
                $_SESSION['uen_editar'] = $uenActual;
            } else {
                $_SESSION['uen_error'] = 'No tienes permiso para editar esta UEN.';
            }
        }
        
        // Redirigir al tablero de objetivos
        header("Location:" . base_url . "objetivoGeneral/index");
        exit();
    }

    public function actualizar() {
        if (isset($_POST) && isset($_SESSION['identity'])) {
            $id_uen = isset($_POST['id_uen']) ? (int) $_POST['id_uen'] : null;
            $textoUen = isset($_POST['uen']) ? $_POST['uen'] : null;
            $id_usuario = $_SESSION['identity']->id;

            if ($id_uen && $textoUen) {
                $uen = new Uen();
                $uen->setIdUen($id_uen);
                $uen->setUen($textoUen);
                $uen->setIdUsuario($id_usuario);

                $actualizado = $uen->actualizar();

                $_SESSION['uen_actualizada'] = $actualizado ? 'completado' : 'fallido';
            }
        }

        // Redirigir al tablero de objetivos
        header("Location:" . base_url . "objetivoGeneral/index");
        exit();
    }
}