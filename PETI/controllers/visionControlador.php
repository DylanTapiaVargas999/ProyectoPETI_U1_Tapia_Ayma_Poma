<?php
require_once 'models/vision.php';

class visionControlador {

    public function index() {
        if (!isset($_SESSION['identity'])) {
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        $id_usuario = $_SESSION['identity']->id;
        $vision = new Vision();
        $visiones = $vision->obtenerPorUsuario($id_usuario);

        require_once 'views/vision/index.php';
    }

    public function guardar() {
        if (isset($_POST) && isset($_SESSION['identity'])) {
            $textoVision = isset($_POST['vision']) ? $_POST['vision'] : null;

            if ($textoVision) {
                $nuevaVision = new Vision();
                $nuevaVision->setVision($textoVision);
                $nuevaVision->setIdUsuario($_SESSION['identity']->id);

                $guardado = $nuevaVision->guardar();

                $_SESSION['vision_guardada'] = $guardado ? 'completado' : 'fallido';
            } else {
                $_SESSION['vision_guardada'] = 'fallido';
            }
        }

        header("Location:" . base_url . "vision/index");
    }

    public function eliminar() {
        if (isset($_GET['id']) && isset($_SESSION['identity'])) {
            $id_vision = (int) $_GET['id'];
            $vision = new Vision();
            $vision->eliminar($id_vision);

            $_SESSION['vision_eliminada'] = 'completado';
        }

        header("Location:" . base_url . "vision/index");
    }

    public function editar() {
        if (isset($_GET['id']) && isset($_SESSION['identity'])) {
            $id_vision = (int) $_GET['id'];
            $id_usuario = $_SESSION['identity']->id;

            $vision = new Vision();
            $resultado = $vision->obtenerPorUsuario($id_usuario);

            $visionActual = null;
            while ($v = $resultado->fetch_object()) {
                if ($v->id_vision == $id_vision) {
                    $visionActual = $v;
                    break;
                }
            }

            if ($visionActual) {
                require_once 'views/vision/editar.php';
            } else {
                $_SESSION['vision_error'] = 'No tienes permiso para editar esta visión.';
                header("Location:" . base_url . "vision/index");
            }
        } else {
            header("Location:" . base_url . "vision/index");
        }
    }

    public function actualizar() {
        if (isset($_POST) && isset($_SESSION['identity'])) {
            $id_vision = isset($_POST['id_vision']) ? (int) $_POST['id_vision'] : null;
            $textoVision = isset($_POST['vision']) ? $_POST['vision'] : null;
            $id_usuario = $_SESSION['identity']->id;

            if ($id_vision && $textoVision) {
                $vision = new Vision();
                $vision->setIdVision($id_vision);
                $vision->setVision($textoVision);
                $vision->setIdUsuario($id_usuario);

                $actualizado = $vision->actualizar();

                $_SESSION['vision_actualizada'] = $actualizado ? 'completado' : 'fallido';
            }
        }

        header("Location:" . base_url . "vision/index");
    }
}
