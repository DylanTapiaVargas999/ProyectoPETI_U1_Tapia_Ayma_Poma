<?php
require_once 'models/Afrontar.php';
require_once 'models/Corregir.php';
require_once 'models/Mantener.php';
require_once 'models/Explotar.php';
require_once 'models/Fortaleza.php';
require_once 'models/Debilidad.php';
require_once 'models/Oportunidad.php';
require_once 'models/Amenaza.php';

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

            // Obtener elementos FODA originales
            $fortaleza = new Fortaleza();
            $fortalezas = $fortaleza->obtenerPorCodigo($codigo_plan);

            $debilidad = new Debilidad();
            $debilidades = $debilidad->obtenerPorCodigo($codigo_plan);

            $oportunidad = new Oportunidad();
            $oportunidades = $oportunidad->obtenerPorCodigo($codigo_plan);

            $amenaza = new Amenaza();
            $amenazas = $amenaza->obtenerPorCodigo($codigo_plan);

            // Verificar errores en la consulta
            if ($fortalezas === false || $debilidades === false || 
                $oportunidades === false || $amenazas === false) {
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
                    $modelo->setIdDebilidad($id) // <-- Aquí va el id_debilidad
                           ->setCorregir($accion)
                           ->setCodigo($codigoPlan)
                           ->setIdUsuario($id_usuario);
                    break;
                
                case 'afrontar':
                    $modelo = new Afrontar();
                    $modelo->setIdAmenaza($id) // <-- Aquí va el id_amenaza
                           ->setAfrontar($accion)
                           ->setCodigo($codigoPlan)
                           ->setIdUsuario($id_usuario);
                    break;
                
                case 'mantener':
                    $modelo = new Mantener();
                    $modelo->setIdFortaleza($id) // <-- Aquí va el id_fortaleza
                          ->setMantener($accion)
                          ->setCodigo($codigoPlan)
                          ->setIdUsuario($id_usuario);
                    break;
                
                case 'explotar':
                    $modelo = new Explotar();
                    $modelo->setIdOportunidad($id) // <-- Aquí va el id_oportunidad
                          ->setExplotar($accion)
                          ->setCodigo($codigoPlan)
                          ->setIdUsuario($id_usuario);
                    break;
            }

            // Intentar actualizar, si falla (no existe), intentar guardar
            if (!$modelo->actualizar()) {
                if (!$modelo->guardar()) {
                    throw new Exception("Error al guardar/actualizar la acción para {$tipo} ID {$id}");
                }
            }
        }
    }
}