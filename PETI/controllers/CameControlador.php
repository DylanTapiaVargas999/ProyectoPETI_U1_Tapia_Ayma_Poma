<?php
require_once 'models/Afrontar.php';
require_once 'models/Corregir.php';
require_once 'models/Mantener.php';
require_once 'models/Explotar.php';

class CameControlador {

    public function index() {
        // Verificar autenticación
        if (!isset($_SESSION['identity'])) {
            $_SESSION['error_came'] = 'Debes iniciar sesión para acceder a esta sección';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        try {
            // Verificar que hay un plan seleccionado
            if (!isset($_SESSION['plan_codigo'])) {
                $_SESSION['error_came'] = 'Debes seleccionar un plan estratégico primero';
                header("Location:" . base_url . "planEstrategico/seleccionar");
                exit();
            }

            $id_usuario = $_SESSION['identity']->id;
            $codigo_plan = $_SESSION['plan_codigo'];

            // Obtener elementos de cada categoría
            $afrontar = new Afrontar();
            $amenazas = $afrontar->obtenerPorCodigo($codigo_plan);

            $corregir = new Corregir();
            $debilidades = $corregir->obtenerPorCodigo($codigo_plan);

            $mantener = new Mantener();
            $fortalezas = $mantener->obtenerPorCodigo($codigo_plan);

            $explotar = new Explotar();
            $oportunidades = $explotar->obtenerPorCodigo($codigo_plan);

            // Verificar errores en la consulta
            if ($amenazas === false || $debilidades === false || $fortalezas === false || $oportunidades === false) {
                $_SESSION['error_came'] = 'Error al cargar los elementos FODA';
            }

            require_once 'views/came/index.php';

        } catch (Exception $e) {
            $_SESSION['error_came'] = 'Error en el sistema: ' . $e->getMessage();
            header("Location:" . base_url . "came/index");
            exit();
        }
    }

    public function guardar() {
        // Verificar autenticación y método POST
        if (!isset($_SESSION['identity']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
            $_SESSION['error_came'] = 'Acceso no autorizado';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        try {
            // Verificar código de plan
            if (!isset($_SESSION['plan_codigo'])) {
                throw new Exception('No has seleccionado un plan activo');
            }

            $codigoPlan = $_SESSION['plan_codigo'];
            $id_usuario = $_SESSION['identity']->id;

            // Procesar cada tipo de acción
            $this->procesarAcciones('corregir', $_POST['debilidades'] ?? [], $codigoPlan, $id_usuario);
            $this->procesarAcciones('afrontar', $_POST['amenazas'] ?? [], $codigoPlan, $id_usuario);
            $this->procesarAcciones('mantener', $_POST['fortalezas'] ?? [], $codigoPlan, $id_usuario);
            $this->procesarAcciones('explotar', $_POST['oportunidades'] ?? [], $codigoPlan, $id_usuario);

            $_SESSION['came_guardado'] = 'completado';

        } catch (Exception $e) {
            $_SESSION['error_came'] = $e->getMessage();
            $_SESSION['came_guardado'] = 'fallido';
        }

        header("Location:" . base_url . "came/index");
        exit();
    }

    private function procesarAcciones($tipo, $elementos, $codigoPlan, $id_usuario) {
        foreach ($elementos as $id => $accion) {
            $accion = trim($accion);
            if (empty($accion)) continue;

            switch ($tipo) {
                case 'corregir':
                    $modelo = new Corregir();
                    $modelo->setIdCorregir($id)
                           ->setCorregir($accion)
                           ->setCodigo($codigoPlan)
                           ->setIdUsuario($id_usuario);
                    break;
                
                case 'afrontar':
                    $modelo = new Afrontar();
                    $modelo->setIdAfrontar($id)
                           ->setAfrontar($accion)
                           ->setCodigo($codigoPlan)
                           ->setIdUsuario($id_usuario);
                    break;
                
                case 'mantener':
                    $modelo = new Mantener();
                    $modelo->setIdMantener($id)
                          ->setMantener($accion)
                          ->setCodigo($codigoPlan)
                          ->setIdUsuario($id_usuario);
                    break;
                
                case 'explotar':
                    $modelo = new Explotar();
                    $modelo->setIdExplotar($id)
                          ->setExplotar($accion)
                          ->setCodigo($codigoPlan)
                          ->setIdUsuario($id_usuario);
                    break;
            }

            if (!$modelo->actualizar()) {
                throw new Exception("Error al actualizar la acción para {$tipo} ID {$id}");
            }
        }
    }

    public function eliminar() {
        if (!isset($_SESSION['identity']) || !isset($_GET['id']) || !isset($_GET['tipo'])) {
            $_SESSION['error_came'] = 'Acceso no autorizado';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        try {
            $id = (int)$_GET['id'];
            $tipo = $_GET['tipo'];
            $id_usuario = $_SESSION['identity']->id;

            switch ($tipo) {
                case 'corregir':
                    $modelo = new Corregir();
                    $modelo->setIdCorregir($id)
                           ->setIdUsuario($id_usuario);
                    break;
                
                case 'afrontar':
                    $modelo = new Afrontar();
                    $modelo->setIdAfrontar($id)
                           ->setIdUsuario($id_usuario);
                    break;
                
                case 'mantener':
                    $modelo = new Mantener();
                    $modelo->setIdMantener($id)
                          ->setIdUsuario($id_usuario);
                    break;
                
                case 'explotar':
                    $modelo = new Explotar();
                    $modelo->setIdExplotar($id)
                          ->setIdUsuario($id_usuario);
                    break;
                
                default:
                    throw new Exception('Tipo de elemento no válido');
            }

            if ($modelo->eliminar()) {
                $_SESSION['came_eliminado'] = 'completado';
            } else {
                throw new Exception('Error al eliminar el elemento');
            }
        } catch (Exception $e) {
            $_SESSION['came_eliminado'] = 'fallido';
            $_SESSION['error_came'] = $e->getMessage();
        }

        header("Location:" . base_url . "came/index");
        exit();
    }
}