<?php
require_once 'models/objetivoEspecifico.php';
require_once 'models/objetivoGeneral.php';

class ObjetivoEspecificoControlador {

    public function index() {
        if (!isset($_GET['id_general']) || !isset($_SESSION['identity'])) {
            header("Location:" . base_url . "objetivoGeneral/index");
            exit();
        }

        $id_general = (int)$_GET['id_general'];
        $id_usuario = $_SESSION['identity']->id;

        // Verificar que el objetivo general pertenece al usuario
        $objetivoGeneral = new ObjetivoGeneral();
        $general = $objetivoGeneral->obtenerPorId($id_general, $id_usuario);

        if (!$general) {
            $_SESSION['objetivo_especifico_error'] = 'No tienes permiso para ver estos objetivos.';
            header("Location:" . base_url . "objetivoGeneral/index");
            exit();
        }

        $objetivoEspecifico = new ObjetivoEspecifico();
        $objetivosEspecificos = $objetivoEspecifico->obtenerPorGeneral($id_general);

        require_once 'views/objetivoEspecifico/index.php';
    }
    public function guardar() {
        if (isset($_POST) && isset($_SESSION['identity']) && isset($_POST['id_general'])) {
            $textoObjetivo = isset($_POST['objetivo']) ? $_POST['objetivo'] : null;
            $id_general = (int)$_POST['id_general'];
    
            if ($textoObjetivo) {
                $nuevoObjetivo = new ObjetivoEspecifico();
                $nuevoObjetivo->setObjetivo($textoObjetivo);
                $nuevoObjetivo->setIdGeneral($id_general);
    
                $guardado = $nuevoObjetivo->guardar();
    
                $_SESSION['objetivo_especifico_guardado'] = $guardado ? 'completado' : 'fallido';
                
                // Redireccionar de vuelta a objetivos generales
                header("Location:" . base_url . "objetivoGeneral/index");
                exit();
            }
        }
        $_SESSION['objetivo_especifico_guardado'] = 'fallido';
        header("Location:" . base_url . "objetivoGeneral/index");
        exit();
    }
    
    public function eliminar() {
        if (isset($_GET['id']) && isset($_GET['id_general']) && isset($_SESSION['identity'])) {
            $id_especifico = (int) $_GET['id'];
            $id_general = (int) $_GET['id_general'];
    
            $objetivoEspecifico = new ObjetivoEspecifico();
            $objetivoEspecifico->eliminar($id_especifico);
    
            $_SESSION['objetivo_especifico_eliminado'] = 'completado';
        }
    
        // Redireccionar de vuelta a objetivos generales
        header("Location:" . base_url . "objetivoGeneral/index");
        exit();
    }

    public function editar() {
        if (isset($_GET['id']) && isset($_GET['id_general']) && isset($_SESSION['identity'])) {
            $id_especifico = (int) $_GET['id'];
            $id_general = (int) $_GET['id_general'];
            $id_usuario = $_SESSION['identity']->id;

            // Verificar permiso
            $objetivoGeneral = new ObjetivoGeneral();
            $general = $objetivoGeneral->obtenerPorId($id_general, $id_usuario);

            if ($general) {
                $objetivoEspecifico = new ObjetivoEspecifico();
                $objetivoActual = $objetivoEspecifico->obtenerPorId($id_especifico, $id_general);

                if ($objetivoActual) {
                    require_once 'views/objetivoEspecifico/editar.php';
                    return;
                }
            }
        }

        $_SESSION['objetivo_especifico_error'] = 'No tienes permiso para editar este objetivo.';
        header("Location:" . base_url . "objetivoEspecifico/index&id_general=" . $id_general);
    }

    public function actualizar() {
        if (isset($_POST) && isset($_SESSION['identity']) && isset($_POST['id_general'])) {
            $id_especifico = isset($_POST['id_especifico']) ? (int) $_POST['id_especifico'] : null;
            $textoObjetivo = isset($_POST['objetivo']) ? $_POST['objetivo'] : null;
            $id_general = (int)$_POST['id_general'];

            // Verificar permiso
            $objetivoGeneral = new ObjetivoGeneral();
            $general = $objetivoGeneral->obtenerPorId($id_general, $_SESSION['identity']->id);

            if ($general && $id_especifico && $textoObjetivo) {
                $objetivoEspecifico = new ObjetivoEspecifico();
                $objetivoEspecifico->setIdEspecifico($id_especifico);
                $objetivoEspecifico->setObjetivo($textoObjetivo);
                $objetivoEspecifico->setIdGeneral($id_general);

                $actualizado = $objetivoEspecifico->actualizar();

                $_SESSION['objetivo_especifico_actualizado'] = $actualizado ? 'completado' : 'fallido';
            }
        }

        header("Location:" . base_url . "objetivoEspecifico/index&id_general=" . $id_general);
    }
}