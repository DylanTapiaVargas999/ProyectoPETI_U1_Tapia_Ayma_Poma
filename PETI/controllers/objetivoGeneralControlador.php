<?php
require_once 'models/objetivoGeneral.php';

class ObjetivoGeneralControlador {

    public function index() {
        if (!isset($_SESSION['identity'])) {
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }
    
        $id_usuario = $_SESSION['identity']->id;
        
        // Cargar modelos
        require_once 'models/uen.php';
        require_once 'models/objetivoEspecifico.php';
        
        $uens = (new Uen())->obtenerPorUsuario($id_usuario);
        $objetivosGenerales = (new ObjetivoGeneral())->obtenerPorUsuario($id_usuario);
        $objetivoEspecificoModel = new ObjetivoEspecifico();
    
        require_once 'views/objetivos/index.php';
    }

    public function guardar() {
        if (isset($_POST) && isset($_SESSION['identity'])) {
            $textoObjetivo = isset($_POST['objetivo']) ? $_POST['objetivo'] : null;

            if ($textoObjetivo) {
                $nuevoObjetivo = new ObjetivoGeneral();
                $nuevoObjetivo->setObjetivo($textoObjetivo);
                $nuevoObjetivo->setIdUsuario($_SESSION['identity']->id);

                $guardado = $nuevoObjetivo->guardar();

                $_SESSION['objetivo_general_guardado'] = $guardado ? 'completado' : 'fallido';
            } else {
                $_SESSION['objetivo_general_guardado'] = 'fallido';
            }
        }

        header("Location:" . base_url . "objetivoGeneral/index");
    }

    public function eliminar() {
        if (isset($_GET['id']) && isset($_SESSION['identity'])) {
            $id_general = (int) $_GET['id'];
            $objetivoGeneral = new ObjetivoGeneral();
            $objetivoGeneral->eliminar($id_general);

            $_SESSION['objetivo_general_eliminado'] = 'completado';
        }

        header("Location:" . base_url . "objetivoGeneral/index");
    }

    public function editar() {
        if (isset($_GET['id']) && isset($_SESSION['identity'])) {
            $id_general = (int) $_GET['id'];
            $id_usuario = $_SESSION['identity']->id;

            $objetivoGeneral = new ObjetivoGeneral();
            $objetivoActual = $objetivoGeneral->obtenerPorId($id_general, $id_usuario);

            if ($objetivoActual) {
                require_once 'views/objetivoGeneral/editar.php';
            } else {
                $_SESSION['objetivo_general_error'] = 'No tienes permiso para editar este objetivo.';
                header("Location:" . base_url . "objetivoGeneral/index");
            }
        } else {
            header("Location:" . base_url . "objetivoGeneral/index");
        }
    }

    public function actualizar() {
        if (isset($_POST) && isset($_SESSION['identity'])) {
            $id_general = isset($_POST['id_general']) ? (int) $_POST['id_general'] : null;
            $textoObjetivo = isset($_POST['objetivo']) ? $_POST['objetivo'] : null;
            $id_usuario = $_SESSION['identity']->id;

            if ($id_general && $textoObjetivo) {
                $objetivoGeneral = new ObjetivoGeneral();
                $objetivoGeneral->setIdGeneral($id_general);
                $objetivoGeneral->setObjetivo($textoObjetivo);
                $objetivoGeneral->setIdUsuario($id_usuario);

                $actualizado = $objetivoGeneral->actualizar();

                $_SESSION['objetivo_general_actualizado'] = $actualizado ? 'completado' : 'fallido';
            }
        }

        header("Location:" . base_url . "objetivoGeneral/index");
    }
}