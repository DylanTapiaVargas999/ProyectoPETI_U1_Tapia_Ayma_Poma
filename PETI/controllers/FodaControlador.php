<?php
require_once 'models/Amenaza.php';
require_once 'models/Debilidad.php';
require_once 'models/Fortaleza.php';
require_once 'models/Oportunidad.php';
require_once 'models/MatrizFO.php';
require_once 'models/MatrizFA.php';
require_once 'models/MatrizDO.php';
require_once 'models/MatrizDA.php';

class FodaControlador {

    public function index() {
        if (!isset($_SESSION['identity'])) {
            $_SESSION['error_foda'] = 'Debes iniciar sesión para acceder a esta sección';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        if (!isset($_SESSION['plan_codigo'])) {
            $_SESSION['error_foda'] = 'Debes seleccionar un plan estratégico primero';
            header("Location:" . base_url . "planEstrategico/seleccionar");
            exit();
        }

        try {
            $id_usuario = $_SESSION['identity']->id;
            $codigo_plan = $_SESSION['plan_codigo'];

            // Obtener elementos FODA
            $fortalezas = $this->obtenerElementos('Fortaleza', $codigo_plan, $id_usuario);
            $debilidades = $this->obtenerElementos('Debilidad', $codigo_plan, $id_usuario);
            $oportunidades = $this->obtenerElementos('Oportunidad', $codigo_plan, $id_usuario);
            $amenazas = $this->obtenerElementos('Amenaza', $codigo_plan, $id_usuario);

            // Obtener matrices existentes
            $matrizFO = $this->obtenerMatriz('MatrizFO', $codigo_plan);
            $matrizFA = $this->obtenerMatriz('MatrizFA', $codigo_plan);
            $matrizDO = $this->obtenerMatriz('MatrizDO', $codigo_plan);
            $matrizDA = $this->obtenerMatriz('MatrizDA', $codigo_plan);

            // Calcular totales estratégicos
            $totales = [
                'FO' => $this->calcularTotalMatriz($matrizFO),
                'FA' => $this->calcularTotalMatriz($matrizFA),
                'DO' => $this->calcularTotalMatriz($matrizDO),
                'DA' => $this->calcularTotalMatriz($matrizDA)
            ];

            // Determinar estrategia principal
            $estrategiaPrincipal = $this->determinarEstrategiaPrincipal($totales);

            require_once 'views/foda/index.php';

        } catch (Exception $e) {
            $_SESSION['error_foda'] = 'Error al cargar los datos FODA: ' . $e->getMessage();
            header("Location:" . base_url . "foda/index");
            exit();
        }
    }

    public function guardarMatrices() {
        if (!isset($_SESSION['identity'])) {
            $_SESSION['error_foda'] = 'Debes iniciar sesión para realizar esta acción';
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        if (!isset($_SESSION['plan_codigo'])) {
            $_SESSION['error_foda'] = 'Debes seleccionar un plan estratégico primero';
            header("Location:" . base_url . "planEstrategico/seleccionar");
            exit();
        }

        try {
            $codigo_plan = $_SESSION['plan_codigo'];
            $exito = true;

            // Procesar matriz FO
            if (isset($_POST['matrizFO'])) {
                foreach ($_POST['matrizFO'] as $id_fortaleza => $oportunidades) {
                    foreach ($oportunidades as $id_oportunidad => $valor) {
                        $matrizFO = new MatrizFO();
                        $matrizFO->setCodigo($codigo_plan)
                                ->setIdFortaleza($id_fortaleza)
                                ->setIdOportunidad($id_oportunidad)
                                ->setValor($valor);

                        // FO
                        if ($matrizFO->existeRelacion($id_fortaleza, $id_oportunidad)) {
                            $matrizExistente = $matrizFO->obtenerPorCodigo($codigo_plan);
                            while ($fila = $matrizExistente->fetch_object()) {
                                if ($fila->id_fortaleza == $id_fortaleza && $fila->id_oportunidad == $id_oportunidad) {
                                    $matrizFO->setIdMatrizFo($fila->id_matriz_fo); // <-- CORRECTO
                                    break;
                                }
                            }
                            $resultado = $matrizFO->actualizar();
                        } else {
                            $resultado = $matrizFO->guardar();
                        }
                        $exito = $exito && $resultado;
                    }
                }
            }

            // Procesar matriz FA
            if (isset($_POST['matrizFA'])) {
                foreach ($_POST['matrizFA'] as $id_fortaleza => $amenazas) {
                    foreach ($amenazas as $id_amenaza => $valor) {
                        $matrizFA = new MatrizFA();
                        $matrizFA->setCodigo($codigo_plan)
                                ->setIdFortaleza($id_fortaleza)
                                ->setIdAmenaza($id_amenaza)
                                ->setValor($valor);

                        // FA
                        if ($matrizFA->existeRelacion($id_fortaleza, $id_amenaza)) {
                            $matrizExistente = $matrizFA->obtenerPorCodigo($codigo_plan);
                            while ($fila = $matrizExistente->fetch_object()) {
                                if ($fila->id_fortaleza == $id_fortaleza && $fila->id_amenaza == $id_amenaza) {
                                    $matrizFA->setIdMatrizFa($fila->id_matriz_fa); // <-- CORRECTO
                                    break;
                                }
                            }
                            $resultado = $matrizFA->actualizar();
                        } else {
                            $resultado = $matrizFA->guardar();
                        }
                        $exito = $exito && $resultado;
                    }
                }
            }

            // Procesar matriz DO
            if (isset($_POST['matrizDO'])) {
                foreach ($_POST['matrizDO'] as $id_debilidad => $oportunidades) {
                    foreach ($oportunidades as $id_oportunidad => $valor) {
                        $matrizDO = new MatrizDO();
                        $matrizDO->setCodigo($codigo_plan)
                                ->setIdDebilidad($id_debilidad)
                                ->setIdOportunidad($id_oportunidad)
                                ->setValor($valor);

                        // DO
                        if ($matrizDO->existeRelacion($id_debilidad, $id_oportunidad)) {
                            $matrizExistente = $matrizDO->obtenerPorCodigo($codigo_plan);
                            while ($fila = $matrizExistente->fetch_object()) {
                                if ($fila->id_debilidad == $id_debilidad && $fila->id_oportunidad == $id_oportunidad) {
                                    $matrizDO->setId($fila->id); // <-- CORRECTO
                                    break;
                                }
                            }
                            $resultado = $matrizDO->actualizar();
                        } else {
                            $resultado = $matrizDO->guardar();
                        }
                        $exito = $exito && $resultado;
                    }
                }
            }

            // Procesar matriz DA
            if (isset($_POST['matrizDA'])) {
                foreach ($_POST['matrizDA'] as $id_debilidad => $amenazas) {
                    foreach ($amenazas as $id_amenaza => $valor) {
                        $matrizDA = new MatrizDA();
                        $matrizDA->setCodigo($codigo_plan)
                                ->setIdDebilidad($id_debilidad)
                                ->setIdAmenaza($id_amenaza)
                                ->setValor($valor);

                        // DA
                        if ($matrizDA->existeRelacion($id_debilidad, $id_amenaza)) {
                            $matrizExistente = $matrizDA->obtenerPorCodigo($codigo_plan);
                            while ($fila = $matrizExistente->fetch_object()) {
                                if ($fila->id_debilidad == $id_debilidad && $fila->id_amenaza == $id_amenaza) {
                                    $matrizDA->setIdMatrizDa($fila->id_matriz_da); // <-- CORRECTO
                                    break;
                                }
                            }
                            $resultado = $matrizDA->actualizar();
                        } else {
                            $resultado = $matrizDA->guardar();
                        }
                        $exito = $exito && $resultado;
                    }
                }
            }

            if ($exito) {
                $_SESSION['exito_foda'] = 'Matrices FODA guardadas correctamente';
            } else {
                $_SESSION['error_foda'] = 'Hubo un error al guardar algunas matrices FODA';
            }

            header("Location:" . base_url . "foda/index");
            exit();

        } catch (Exception $e) {
            $_SESSION['error_foda'] = 'Error al guardar las matrices FODA: ' . $e->getMessage();
            header("Location:" . base_url . "foda/index");
            exit();
        }
    }

    // Métodos auxiliares
    private function obtenerElementos($tipo, $codigo_plan, $id_usuario) {
        $elementos = [];
        $modelo = new $tipo();
        $result = $modelo->obtenerPorCodigo($codigo_plan);
        
        while ($row = $result->fetch_object()) {
            if ($row->id_usuario == $id_usuario) {
                $elementos[] = $row;
            }
        }
        
        return $elementos;
    }

    private function obtenerMatriz($tipo, $codigo_plan) {
        $matriz = [];
        $modelo = new $tipo();
        $result = $modelo->obtenerPorCodigo($codigo_plan);
        
        while ($row = $result->fetch_object()) {
            $matriz[] = $row;
        }
        
        return $matriz;
    }

    private function calcularTotalMatriz($matriz) {
        $total = 0;
        foreach ($matriz as $relacion) {
            $total += $relacion->valor;
        }
        return $total;
    }

    private function determinarEstrategiaPrincipal($totales) {
        $maximo = max($totales);
        $estrategias = [];
        
        foreach ($totales as $tipo => $valor) {
            if ($valor == $maximo) {
                $estrategias[] = $tipo;
            }
        }
        
        if (count($estrategias) > 1) {
            return 'Múltiples estrategias (' . implode(', ', $estrategias) . ')';
        }
        
        return $estrategias[0];
    }
}