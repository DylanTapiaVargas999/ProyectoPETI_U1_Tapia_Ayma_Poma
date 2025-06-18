<?php
// filepath: c:\xampp\htdocs\PETI\controllers\dashboardControlador.php
require_once 'models/usuario.php';
require_once 'models/planEstrategico.php';
require_once 'models/mision.php';
require_once 'models/vision.php';
require_once 'models/valor.php';
require_once 'models/fortaleza.php';
require_once 'models/debilidad.php';
require_once 'models/oportunidad.php';
require_once 'models/amenaza.php';
require_once 'models/encuestaCadena.php';
require_once 'models/encuestaPorter.php';
require_once 'models/encuestaPest.php';
require_once 'models/corregir.php';
require_once 'models/afrontar.php';
require_once 'models/mantener.php';
require_once 'models/explotar.php';

class dashboardControlador {
    
    public function index() {
        // Verificar que esté logueado y tenga plan seleccionado
        if (!isset($_SESSION['identity']) || !isset($_SESSION['plan_codigo'])) {
            header("Location: " . base_url);
            exit();
        }

        $usuario = $_SESSION['identity'];
        $codigo_plan = $_SESSION['plan_codigo'];

        // Obtener progreso de cada sección
        $progreso = $this->calcularProgreso($usuario->id, $codigo_plan);

        // Pasar datos a la vista
        require_once 'views/dashboard/index.php';
    }

    private function calcularProgreso($id_usuario, $codigo_plan) {
        $progreso = [
            'mision' => 0,
            'vision' => 0, 
            'valores' => 0,
            'objetivos' => 0,
            'foda' => 0,
            'cadena_valor' => 0,
            'bcg' => 0,
            'porter' => 0,
            'pestel' => 0,
            'estrategias' => 0,
            'came' => 0,
            'general' => 0
        ];

        try {
            // Verificar Misión
            $misionModel = new Mision();
            $misiones = $misionModel->obtenerPorCodigoPlan($codigo_plan, $id_usuario);
            $progreso['mision'] = ($misiones && $misiones->num_rows > 0) ? 100 : 0;

            // Verificar Visión
            $visionModel = new Vision();
            $visiones = $visionModel->obtenerPorCodigoPlan($codigo_plan, $id_usuario);
            $progreso['vision'] = ($visiones && $visiones->num_rows > 0) ? 100 : 0;

            // Verificar Valores
            $valorModel = new Valor();
            $valores = $valorModel->obtenerPorCodigoPlan($codigo_plan, $id_usuario);
            $progreso['valores'] = ($valores && $valores->num_rows > 0) ? 100 : 0;

            // Verificar Objetivos (usando UEN como proxy)
            try {
                require_once 'models/uen.php';
                $uenModel = new Uen();
                $uenes = $uenModel->obtenerPorUsuarioYPlan($id_usuario, $codigo_plan);
                $progreso['objetivos'] = ($uenes && $uenes->num_rows > 0) ? 100 : 0;
            } catch (Exception $e) {
                $progreso['objetivos'] = 0;
            }

            // Verificar FODA
            $fortalezaModel = new Fortaleza();
            $fortalezas = $fortalezaModel->obtenerPorCodigo($codigo_plan);
            
            $debilidadModel = new Debilidad();
            $debilidades = $debilidadModel->obtenerPorCodigo($codigo_plan);
            
            $oportunidadModel = new Oportunidad();
            $oportunidades = $oportunidadModel->obtenerPorCodigo($codigo_plan);
            
            $amenazaModel = new Amenaza();
            $amenazas = $amenazaModel->obtenerPorCodigo($codigo_plan);
            
            $total_foda = 0;
            if ($fortalezas && $fortalezas->num_rows > 0) $total_foda += 25;
            if ($debilidades && $debilidades->num_rows > 0) $total_foda += 25;
            if ($oportunidades && $oportunidades->num_rows > 0) $total_foda += 25;
            if ($amenazas && $amenazas->num_rows > 0) $total_foda += 25;
            
            $progreso['foda'] = $total_foda;

            // Verificar Cadena de Valor
            $encuestaCadenaModel = new EncuestaCadena();
            $encuestaCadena = $encuestaCadenaModel->obtenerPorCodigo($codigo_plan);
            $progreso['cadena_valor'] = ($encuestaCadena) ? 100 : 0;

            // Verificar BCG (productos con datos completos)
            try {
                require_once 'models/producto.php';
                $productoModel = new Producto();
                $total_productos = $productoModel->contarProductos($codigo_plan);
                $productos_completos = $productoModel->contarProductosCompletos($codigo_plan);
                
                if ($total_productos > 0) {
                    $porcentaje_bcg = ($productos_completos / $total_productos) * 100;
                    $progreso['bcg'] = $porcentaje_bcg;
                } else {
                    $progreso['bcg'] = 0;
                }
            } catch (Exception $e) {
                $progreso['bcg'] = 0;
                error_log("Error en BCG: " . $e->getMessage());
            }

            // Verificar Porter
            $encuestaPorterModel = new EncuestaPorter();
            $encuestaPorter = $encuestaPorterModel->obtenerPorCodigo($codigo_plan);
            $progreso['porter'] = ($encuestaPorter) ? 100 : 0;

            // Verificar PESTEL
            $encuestaPestModel = new EncuestaPest();
            $encuestaPest = $encuestaPestModel->obtenerPorCodigo($codigo_plan);
            $progreso['pestel'] = ($encuestaPest) ? 100 : 0;

            // Verificar Estrategias (localStorage se verifica en frontend)
            $progreso['estrategias'] = 0; // Por defecto, se actualiza en frontend

            // Verificar CAME
            $corregirModel = new Corregir();
            $mantenerModel = new Mantener();
            $afrontarModel = new Afrontar();
            $explotarModel = new Explotar();
            
            $total_came = 0;
            if ($debilidades && $debilidades->num_rows > 0) {
                $acciones_corregir = $corregirModel->obtenerPorCodigo($codigo_plan);
                if ($acciones_corregir && $acciones_corregir->num_rows > 0) $total_came += 25;
            }

            if ($amenazas && $amenazas->num_rows > 0) {
                $acciones_afrontar = $afrontarModel->obtenerPorCodigo($codigo_plan);
                if ($acciones_afrontar && $acciones_afrontar->num_rows > 0) $total_came += 25;
            }

            if ($fortalezas && $fortalezas->num_rows > 0) {
                $acciones_mantener = $mantenerModel->obtenerPorCodigo($codigo_plan);
                if ($acciones_mantener && $acciones_mantener->num_rows > 0) $total_came += 25;
            }

            if ($oportunidades && $oportunidades->num_rows > 0) {
                $acciones_explotar = $explotarModel->obtenerPorCodigo($codigo_plan);
                if ($acciones_explotar && $acciones_explotar->num_rows > 0) $total_came += 25;
            } 
            
            $progreso['came'] = $total_came;

            // Calcular progreso general
            $total = 0;
            $secciones = 0;
            foreach ($progreso as $clave => $valor) {
                if ($clave != 'general') { // Evita incluir el propio 'general'
                    $total += $valor;
                    $secciones++;
                }
            }
            $progreso['general'] = $secciones > 0 ? round($total / $secciones) : 0;

        } catch (Exception $e) {
            error_log("Error en calcularProgreso: " . $e->getMessage());
        }

        return $progreso;
    }
}
?>