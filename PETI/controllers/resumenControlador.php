<?php

require_once 'models/Mision.php';
require_once 'models/Vision.php';
require_once 'models/Valor.php'; // Asegúrate que este modelo exista y funcione como se espera
require_once 'models/Uen.php';
require_once 'models/ObjetivoGeneral.php';
// El modelo ObjetivoEspecifico suele ser manejado a través de ObjetivoGeneral
require_once 'models/Fortaleza.php';
require_once 'models/Debilidad.php';
require_once 'models/Oportunidad.php';
require_once 'models/Amenaza.php';
require_once 'models/Corregir.php';
require_once 'models/Afrontar.php';
require_once 'models/Mantener.php';
require_once 'models/Explotar.php';

class ResumenControlador {

    public function index() {
        if (!isset($_SESSION['identity'])) {
            $_SESSION['error_resumen'] = 'Debes iniciar sesión para acceder a esta sección.';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        if (!isset($_SESSION['plan_codigo'])) {
            $_SESSION['error_resumen'] = 'Debes seleccionar un plan estratégico primero.';
            header("Location:" . base_url . "planEstrategico/seleccionar");
            exit();
        }

        $id_usuario = $_SESSION['identity']->id;
        $codigo_plan = $_SESSION['plan_codigo'];

        // Datos del usuario (para foto y nombre)
        $usuario = $_SESSION['identity'];

        // Datos del plan (para fecha)
        require_once 'models/planEstrategico.php';
        $planModel = new PlanEstrategico();
        $plan = $planModel->obtenerPorCodigo($codigo_plan, $id_usuario);

        // Cargar datos
        $misionModel = new Mision();
        $misiones = $misionModel->obtenerPorCodigoPlan($codigo_plan, $id_usuario);

        $visionModel = new Vision();
        $visiones = $visionModel->obtenerPorCodigoPlan($codigo_plan, $id_usuario);

        $valorModel = new Valor();
        $valores = $valorModel->obtenerPorCodigoPlan($codigo_plan, $id_usuario);

        $uenModel = new Uen();
        $uenes = $uenModel->obtenerPorUsuarioYPlan($id_usuario, $codigo_plan);

        $objetivoGeneralModel = new ObjetivoGeneral();
        $objetivosGenerales = $objetivoGeneralModel->obtenerConEspecificos($id_usuario, $codigo_plan);

        $fortalezaModel = new Fortaleza();
        $fortalezas = $fortalezaModel->obtenerPorCodigo($codigo_plan);

        $debilidadModel = new Debilidad();
        $debilidades = $debilidadModel->obtenerPorCodigo($codigo_plan);

        $oportunidadModel = new Oportunidad();
        $oportunidades = $oportunidadModel->obtenerPorCodigo($codigo_plan);

        $amenazaModel = new Amenaza();
        $amenazas = $amenazaModel->obtenerPorCodigo($codigo_plan);

        // Modelos CAME para usar en la vista
        $corregirModel = new Corregir();
        $afrontarModel = new Afrontar();
        $mantenerModel = new Mantener();
        $explotarModel = new Explotar();

        require_once 'views/resumen/index.php';
    }

    public function exportarPdf() {
        if (!isset($_SESSION['identity']) || !isset($_SESSION['plan_codigo'])) {
            header("Location: " . base_url . "usuario/iniciarSesion");
            exit();
        }

        // Carga los mismos datos que en index()
        $id_usuario = $_SESSION['identity']->id;
        $codigo_plan = $_SESSION['plan_codigo'];
        $usuario = $_SESSION['identity'];
        require_once 'models/planEstrategico.php';
        $planModel = new PlanEstrategico();
        $plan = $planModel->obtenerPorCodigo($codigo_plan, $id_usuario);

        $misionModel = new Mision();
        $misiones = $misionModel->obtenerPorCodigoPlan($codigo_plan, $id_usuario);

        $visionModel = new Vision();
        $visiones = $visionModel->obtenerPorCodigoPlan($codigo_plan, $id_usuario);

        $valorModel = new Valor();
        $valores = $valorModel->obtenerPorCodigoPlan($codigo_plan, $id_usuario);

        $uenModel = new Uen();
        $uenes = $uenModel->obtenerPorUsuarioYPlan($id_usuario, $codigo_plan);

        $objetivoGeneralModel = new ObjetivoGeneral();
        $objetivosGenerales = $objetivoGeneralModel->obtenerConEspecificos($id_usuario, $codigo_plan);

        $fortalezaModel = new Fortaleza();
        $fortalezas = $fortalezaModel->obtenerPorCodigo($codigo_plan);

        $debilidadModel = new Debilidad();
        $debilidades = $debilidadModel->obtenerPorCodigo($codigo_plan);

        $oportunidadModel = new Oportunidad();
        $oportunidades = $oportunidadModel->obtenerPorCodigo($codigo_plan);

        $amenazaModel = new Amenaza();
        $amenazas = $amenazaModel->obtenerPorCodigo($codigo_plan);

        // Captura el HTML de la vista resumen
        ob_start();
        require 'views/resumen/pdf.php'; // Crea esta vista para el PDF
        $html = ob_get_clean();

        // Usa mPDF para generar el PDF
        require_once __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta si es necesario
        $mpdf = new \Mpdf\Mpdf(['utf-8', 'A4']);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Resumen_Plan.pdf', 'D'); // 'D' fuerza descarga, 'I' lo muestra en el navegador
        exit();
    }
}
?>