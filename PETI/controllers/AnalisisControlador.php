<?php
require_once 'models/EncuestaCadena.php';
require_once 'models/Fortaleza.php';
require_once 'models/Debilidad.php';

class AnalisisControlador {

    public function index() {
        if (!isset($_SESSION['identity'])) {
            $_SESSION['error_analisis'] = 'Debes iniciar sesión para acceder a esta sección';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        try {
            // Verificar que hay un plan seleccionado
            if (!isset($_SESSION['plan_codigo'])) {
                $_SESSION['error_analisis'] = 'Debes seleccionar un plan estratégico primero';
                header("Location:" . base_url . "planEstrategico/seleccionar");
                exit();
            }

            $id_usuario = $_SESSION['identity']->id;
            $codigo_plan = $_SESSION['plan_codigo'];

            // Instanciar los modelos
            $encuesta = new EncuestaCadena();
            $fortaleza = new Fortaleza();
            $debilidad = new Debilidad();

            // Obtener datos de cada modelo
            $datos_encuesta = $encuesta->obtenerPorCodigo($codigo_plan);
            $fortalezas = $fortaleza->obtenerPorCodigo($codigo_plan);
            $debilidades = $debilidad->obtenerPorCodigo($codigo_plan);

            // 🔧 MODO EDICIÓN
            $edicion_encuesta = isset($_GET['editar_encuesta']) && is_numeric($_GET['editar_encuesta']);
            $edicion_fortaleza = isset($_GET['editar_fortaleza']) && is_numeric($_GET['editar_fortaleza']);
            $edicion_debilidad = isset($_GET['editar_debilidad']) && is_numeric($_GET['editar_debilidad']);

            // Obtener datos para edición si es necesario
            $encuesta_actual = null;
            $fortaleza_actual = null;
            $debilidad_actual = null;

            if ($edicion_encuesta) {
                $encuesta_actual = $encuesta->obtenerUno($_GET['editar_encuesta']);
                if (!$encuesta_actual || $encuesta_actual->id_usuario != $id_usuario) {
                    $_SESSION['error_analisis'] = 'No tienes permiso para editar esta encuesta';
                    $edicion_encuesta = false;
                }
            }

            if ($edicion_fortaleza) {
                $fortaleza_actual = $fortaleza->obtenerPorIdYUsuario($_GET['editar_fortaleza'], $id_usuario);
                if (!$fortaleza_actual) {
                    $_SESSION['error_analisis'] = 'No tienes permiso para editar esta fortaleza';
                    $edicion_fortaleza = false;
                }
            }

            if ($edicion_debilidad) {
                $debilidad_actual = $debilidad->obtenerPorIdYUsuario($_GET['editar_debilidad'], $id_usuario);
                if (!$debilidad_actual) {
                    $_SESSION['error_analisis'] = 'No tienes permiso para editar esta debilidad';
                    $edicion_debilidad = false;
                }
            }

            require_once 'views/analisis/index.php';

        } catch (Exception $e) {
            $_SESSION['error_analisis'] = 'Error en el sistema: ' . $e->getMessage();
            header("Location:" . base_url . "analisis/index");
            exit();
        }
    }

    public function guardarEncuesta() {
        if (!isset($_SESSION['identity']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
            $_SESSION['error_analisis'] = 'Acceso no autorizado';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        try {
            if (!isset($_SESSION['plan_codigo'])) {
                throw new Exception('No has seleccionado un plan activo');
            }

            $id_usuario = $_SESSION['identity']->id;
            $codigo_plan = $_SESSION['plan_codigo'];
            $id_encuesta = $_POST['id_encuesta'] ?? null;

            // Validar que todas las preguntas estén presentes
            $preguntas = [];
            for ($i = 1; $i <= 25; $i++) {
                $preguntas['p'.$i] = isset($_POST['p'.$i]) ? (int)$_POST['p'.$i] : 0;
            }

            $reflexion = trim($_POST['reflexion'] ?? '');

            $encuesta = new EncuestaCadena();
            
            // Establecer todas las propiedades
            $encuesta->setP1($preguntas['p1'])
                    ->setP2($preguntas['p2'])
                    ->setP3($preguntas['p3'])
                    ->setP4($preguntas['p4'])
                    ->setP5($preguntas['p5'])
                    ->setP6($preguntas['p6'])
                    ->setP7($preguntas['p7'])
                    ->setP8($preguntas['p8'])
                    ->setP9($preguntas['p9'])
                    ->setP10($preguntas['p10'])
                    ->setP11($preguntas['p11'])
                    ->setP12($preguntas['p12'])
                    ->setP13($preguntas['p13'])
                    ->setP14($preguntas['p14'])
                    ->setP15($preguntas['p15'])
                    ->setP16($preguntas['p16'])
                    ->setP17($preguntas['p17'])
                    ->setP18($preguntas['p18'])
                    ->setP19($preguntas['p19'])
                    ->setP20($preguntas['p20'])
                    ->setP21($preguntas['p21'])
                    ->setP22($preguntas['p22'])
                    ->setP23($preguntas['p23'])
                    ->setP24($preguntas['p24'])
                    ->setP25($preguntas['p25'])
                    ->setCodigo($codigo_plan)
                    ->setReflexion($reflexion)
                    ->setIdUsuario($id_usuario);

            if ($id_encuesta) {
                // Modo edición
                $encuesta->setIdEncuestaCadena($id_encuesta);
                $resultado = $encuesta->actualizar();
                $_SESSION['encuesta_actualizada'] = $resultado ? 'completado' : 'fallido';
            } else {
                // Modo creación
                $resultado = $encuesta->guardar();
                $_SESSION['encuesta_guardada'] = $resultado ? 'completado' : 'fallido';
            }

            if (!$resultado) {
                throw new Exception('Error al procesar la encuesta en la base de datos');
            }

        } catch (Exception $e) {
            $_SESSION['error_analisis'] = $e->getMessage();
            if ($id_encuesta) {
                $_SESSION['encuesta_actualizada'] = 'fallido';
            } else {
                $_SESSION['encuesta_guardada'] = 'fallido';
            }
        }

        header("Location:" . base_url . "analisis/index");
        exit();
    }

    public function guardarFortaleza() {
        if (!isset($_SESSION['identity']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
            $_SESSION['error_analisis'] = 'Acceso no autorizado';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        try {
            if (!isset($_SESSION['plan_codigo'])) {
                throw new Exception('No has seleccionado un plan activo');
            }

            $textoFortaleza = trim($_POST['fortaleza'] ?? '');
            $codigoPlan = $_SESSION['plan_codigo'];
            $id_fortaleza = $_POST['id_fortaleza'] ?? null;

            if (empty($textoFortaleza)) {
                throw new Exception('La fortaleza no puede estar vacía');
            }

            $fortaleza = new Fortaleza();
            $fortaleza->setFortaleza($textoFortaleza)
                     ->setCodigo($codigoPlan)
                     ->setIdUsuario($_SESSION['identity']->id);

            if ($id_fortaleza) {
                // Modo edición
                $fortaleza->setIdFortaleza($id_fortaleza);
                $resultado = $fortaleza->actualizar();
                $_SESSION['fortaleza_actualizada'] = $resultado ? 'completado' : 'fallido';
            } else {
                // Modo creación
                $resultado = $fortaleza->guardar();
                $_SESSION['fortaleza_guardada'] = $resultado ? 'completado' : 'fallido';
            }

            if (!$resultado) {
                throw new Exception('Error al procesar la fortaleza en la base de datos');
            }

        } catch (Exception $e) {
            $_SESSION['error_analisis'] = $e->getMessage();
            if ($id_fortaleza) {
                $_SESSION['fortaleza_actualizada'] = 'fallido';
            } else {
                $_SESSION['fortaleza_guardada'] = 'fallido';
            }
        }

        header("Location:" . base_url . "analisis/index");
        exit();
    }

    public function guardarDebilidad() {
        if (!isset($_SESSION['identity']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
            $_SESSION['error_analisis'] = 'Acceso no autorizado';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        try {
            if (!isset($_SESSION['plan_codigo'])) {
                throw new Exception('No has seleccionado un plan activo');
            }

            $textoDebilidad = trim($_POST['debilidad'] ?? '');
            $codigoPlan = $_SESSION['plan_codigo'];
            $id_debilidad = $_POST['id_debilidad'] ?? null;

            if (empty($textoDebilidad)) {
                throw new Exception('La debilidad no puede estar vacía');
            }

            $debilidad = new Debilidad();
            $debilidad->setDebilidad($textoDebilidad)
                      ->setCodigo($codigoPlan)
                      ->setIdUsuario($_SESSION['identity']->id);

            if ($id_debilidad) {
                // Modo edición
                $debilidad->setIdDebilidad($id_debilidad);
                $resultado = $debilidad->actualizar();
                $_SESSION['debilidad_actualizada'] = $resultado ? 'completado' : 'fallido';
            } else {
                // Modo creación
                $resultado = $debilidad->guardar();
                $_SESSION['debilidad_guardada'] = $resultado ? 'completado' : 'fallido';
            }

            if (!$resultado) {
                throw new Exception('Error al procesar la debilidad en la base de datos');
            }

        } catch (Exception $e) {
            $_SESSION['error_analisis'] = $e->getMessage();
            if ($id_debilidad) {
                $_SESSION['debilidad_actualizada'] = 'fallido';
            } else {
                $_SESSION['debilidad_guardada'] = 'fallido';
            }
        }

        header("Location:" . base_url . "analisis/index");
        exit();
    }

    public function eliminarFortaleza() {
        if (!isset($_SESSION['identity']) || !isset($_GET['id'])) {
            $_SESSION['error_analisis'] = 'Acceso no autorizado';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        try {
            $id_fortaleza = (int)$_GET['id'];
            $id_usuario = $_SESSION['identity']->id;

            $fortaleza = new Fortaleza();
            $fortaleza->setIdFortaleza($id_fortaleza)
                     ->setIdUsuario($id_usuario);

            if ($fortaleza->eliminar()) {
                $_SESSION['fortaleza_eliminada'] = 'completado';
            } else {
                throw new Exception('Error al eliminar la fortaleza');
            }
        } catch (Exception $e) {
            $_SESSION['fortaleza_eliminada'] = 'fallido';
            $_SESSION['error_analisis'] = $e->getMessage();
        }

        header("Location:" . base_url . "analisis/index");
        exit();
    }

    public function eliminarDebilidad() {
        if (!isset($_SESSION['identity']) || !isset($_GET['id'])) {
            $_SESSION['error_analisis'] = 'Acceso no autorizado';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        try {
            $id_debilidad = (int)$_GET['id'];
            $id_usuario = $_SESSION['identity']->id;

            $debilidad = new Debilidad();
            $debilidad->setIdDebilidad($id_debilidad)
                     ->setIdUsuario($id_usuario);

            if ($debilidad->eliminar()) {
                $_SESSION['debilidad_eliminada'] = 'completado';
            } else {
                throw new Exception('Error al eliminar la debilidad');
            }
        } catch (Exception $e) {
            $_SESSION['debilidad_eliminada'] = 'fallido';
            $_SESSION['error_analisis'] = $e->getMessage();
        }

        header("Location:" . base_url . "analisis/index");
        exit();
    }

    // Métodos auxiliares que podrías necesitar
    private function obtenerPorIdYUsuario($modelo, $id, $id_usuario) {
        switch ($modelo) {
            case 'fortaleza':
                $obj = new Fortaleza();
                break;
            case 'debilidad':
                $obj = new Debilidad();
                break;
            default:
                return false;
        }

        $obj->setId($id)->setIdUsuario($id_usuario);
        return $obj->obtenerUno();
    }
}