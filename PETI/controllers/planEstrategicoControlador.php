<?php
require_once 'models/planEstrategico.php';

class planEstrategicoControlador {

    public function index() {
        if (!isset($_SESSION['identity'])) {
            header("Location:" . base_url . "?controlador=usuario&accion=iniciarSesion");
            exit();
        }

        $plan = new PlanEstrategico();
        $planes = $plan->obtenerPorUsuario($_SESSION['identity']->id);

        require_once 'views/planEstrategico/index.php';
    }

    public function crear() {
        require_once 'views/planEstrategico/crear.php';
    }

    private function generarCodigo($longitud = 8) {
        return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $longitud);
    }
    
    public function guardar() {
        if ($_POST) {
            $plan = new PlanEstrategico();
    
            // Generar código único
            $codigoGenerado = $this->generarCodigo();
    
            $plan->setCodigo($codigoGenerado);
            $plan->setTitulo($_POST['titulo']);
            $plan->setIdUsuario($_SESSION['identity']->id);
    
            $plan->guardar();
    
            // Almacenar el código en la sesión
            $_SESSION['codigo_plan'] = $codigoGenerado;
        }
    
        header("Location:" . base_url . "planEstrategico/index");
    }
    
    

    public function eliminar() {
        if (isset($_GET['id'])) {
            $plan = new PlanEstrategico();
            $plan->eliminar($_GET['id']);
        }
        header("Location:" . base_url . "planEstrategico/index");
    }

    public function editar() {
        if (isset($_GET['id'])) {
            $plan = new PlanEstrategico();
            $resultado = $plan->obtenerPorUsuario($_SESSION['identity']->id);
            require_once 'views/planEstrategico/editar.php';
        }
    }

    public function actualizar() {
        if ($_POST) {
            $plan = new PlanEstrategico();
            $plan->setId($_POST['id']);
            $plan->setCodigo($_POST['codigo']);
            $plan->setTitulo($_POST['titulo']);
            $plan->setIdUsuario($_SESSION['identity']->id);

            $plan->actualizar();
        }

        header("Location:" . base_url . "planEstrategico/index");
    }
}
