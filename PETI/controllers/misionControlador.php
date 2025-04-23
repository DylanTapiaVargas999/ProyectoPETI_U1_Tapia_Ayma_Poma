<?php
require_once 'models/mision.php';

class misionControlador {

    public function index() {
        // Verifica si el usuario está logueado
        if (!isset($_SESSION['identity'])) {
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        $id_usuario = $_SESSION['identity']->id;
        $mision = new Mision();
        $misiones = $mision->obtenerPorUsuario($id_usuario);

        require_once 'views/mision/index.php';
    }

    public function guardar() {
        if (isset($_POST) && isset($_SESSION['identity'])) {
            $textoMision = isset($_POST['mision']) ? $_POST['mision'] : null;

            if ($textoMision) {
                $nuevaMision = new Mision();
                $nuevaMision->setMision($textoMision);
                $nuevaMision->setIdUsuario($_SESSION['identity']->id);

                $guardado = $nuevaMision->guardar();

                $_SESSION['mision_guardada'] = $guardado ? 'completado' : 'fallido';
            } else {
                $_SESSION['mision_guardada'] = 'fallido';
            }
        }

        header("Location:" . base_url . "mision/index");
    }

    public function eliminar() {
        if (isset($_GET['id']) && isset($_SESSION['identity'])) {
            $id_mision = (int) $_GET['id'];
            $mision = new Mision();
            $mision->eliminar($id_mision);

            $_SESSION['mision_eliminada'] = 'completado';
        }

        header("Location:" . base_url . "mision/index");
    }

    public function editar() {
        if (isset($_GET['id']) && isset($_SESSION['identity'])) {
            $id_mision = (int) $_GET['id'];
            $id_usuario = $_SESSION['identity']->id;

            $mision = new Mision();
            $resultado = $mision->obtenerPorUsuario($id_usuario);

            $misionActual = null;
            while ($m = $resultado->fetch_object()) {
                if ($m->id_mision == $id_mision) {
                    $misionActual = $m;
                    break;
                }
            }

            if ($misionActual) {
                require_once 'views/mision/editar.php';
            } else {
                $_SESSION['mision_error'] = 'No tienes permiso para editar esta misión.';
                header("Location:" . base_url . "mision/index");
            }
        } else {
            header("Location:" . base_url . "mision/index");
        }
    }

    public function actualizar() {
        if (isset($_POST) && isset($_SESSION['identity'])) {
            $id_mision = isset($_POST['id_mision']) ? (int) $_POST['id_mision'] : null;
            $textoMision = isset($_POST['mision']) ? $_POST['mision'] : null;
            $id_usuario = $_SESSION['identity']->id;

            if ($id_mision && $textoMision) {
                $mision = new Mision();
                $mision->setIdMision($id_mision);
                $mision->setMision($textoMision);
                $mision->setIdUsuario($id_usuario);

                $actualizado = $mision->actualizar();

                $_SESSION['mision_actualizada'] = $actualizado ? 'completado' : 'fallido';
            }
        }

        header("Location:" . base_url . "mision/index");
    }
}
