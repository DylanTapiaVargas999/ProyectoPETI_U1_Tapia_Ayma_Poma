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

        // Obtener elementos FODA básicos
        $fortalezaModel = new Fortaleza();
        $debilidadModel = new Debilidad();
        $oportunidadModel = new Oportunidad();
        $amenazaModel = new Amenaza();

        $fortalezas = $this->filtrarPorUsuario($fortalezaModel->obtenerPorCodigo($codigo_plan), $id_usuario);
        $debilidades = $this->filtrarPorUsuario($debilidadModel->obtenerPorCodigo($codigo_plan), $id_usuario);
        $oportunidades = $this->filtrarPorUsuario($oportunidadModel->obtenerPorCodigo($codigo_plan), $id_usuario);
        $amenazas = $this->filtrarPorUsuario($amenazaModel->obtenerPorCodigo($codigo_plan), $id_usuario);

        // Obtener matrices FODA
        $matrizFO = new MatrizFO();
        $matrizFA = new MatrizFA();
        $matrizDO = new MatrizDO();
        $matrizDA = new MatrizDA();

        // Obtener todas las relaciones para cada matriz
        $relacionesFO = $matrizFO->obtenerPorCodigo($codigo_plan);
        $relacionesFA = $matrizFA->obtenerPorCodigo($codigo_plan);
        $relacionesDO = $matrizDO->obtenerPorCodigo($codigo_plan);
        $relacionesDA = $matrizDA->obtenerPorCodigo($codigo_plan);

        // Calcular totales para cada estrategia
        $totalFO = $this->calcularTotal($relacionesFO);
        $totalFA = $this->calcularTotal($relacionesFA);
        $totalDO = $this->calcularTotal($relacionesDO);
        $totalDA = $this->calcularTotal($relacionesDA);

        // Determinar la estrategia principal (la de mayor puntuación)
        $estrategias = [
            'FO' => $totalFO,
            'FA' => $totalFA,
            'DO' => $totalDO,
            'DA' => $totalDA
        ];
        $estrategiaPrincipal = array_search(max($estrategias), $estrategias);

        require_once 'views/foda/index.php';

    } catch (Exception $e) {
        $_SESSION['error_foda'] = 'Error al cargar los datos FODA: ' . $e->getMessage();
        header("Location:" . base_url . "foda/index");
        exit();
    }
}
public function guardarRelacion() {
    if (!isset($_SESSION['plan_codigo'])) {
        echo json_encode(['success' => false, 'msg' => 'No hay plan seleccionado']);
        exit;
    }

    $tipo = $_POST['tipo'] ?? '';
    $id1 = $_POST['id_elemento1'] ?? null;
    $id2 = $_POST['id_elemento2'] ?? null;
    $valor = $_POST['valor'] ?? 0;
    $codigo = $_SESSION['plan_codigo'];

    $success = false;

    switch ($tipo) {
        case 'FO':
            $matriz = new MatrizFO();
            $matriz->setCodigo($codigo)
                   ->setValor($valor)
                   ->setIdFortaleza($id1)
                   ->setIdOportunidad($id2);
            // Si existe, actualiza; si no, guarda
            if ($matriz->existeRelacion($id1, $id2)) {
                // Buscar el id para actualizar
                $rel = $matriz->obtenerPorCodigo($codigo);
                while ($row = $rel->fetch_object()) {
                    if ($row->id_fortaleza == $id1 && $row->id_oportunidad == $id2) {
                        $matriz->setIdMatrizFo($row->id_matriz_fo);
                        $success = $matriz->actualizar();
                        break;
                    }
                }
            } else {
                $success = $matriz->guardar();
            }
            break;
        case 'FA':
            $matriz = new MatrizFA();
            $matriz->setCodigo($codigo)
                   ->setValor($valor)
                   ->setIdFortaleza($id1)
                   ->setIdAmenaza($id2);
            if ($matriz->existeRelacion($id1, $id2)) {
                $rel = $matriz->obtenerPorCodigo($codigo);
                while ($row = $rel->fetch_object()) {
                    if ($row->id_fortaleza == $id1 && $row->id_amenaza == $id2) {
                        $matriz->setIdMatrizFa($row->id_matriz_fa);
                        $success = $matriz->actualizar();
                        break;
                    }
                }
            } else {
                $success = $matriz->guardar();
            }
            break;
        case 'DO':
            $matriz = new MatrizDO();
            $matriz->setCodigo($codigo)
                   ->setValor($valor)
                   ->setIdDebilidad($id1)
                   ->setIdOportunidad($id2);
            if ($matriz->existeRelacion($id1, $id2)) {
                $rel = $matriz->obtenerPorCodigo($codigo);
                while ($row = $rel->fetch_object()) {
                    if ($row->id_debilidad == $id1 && $row->id_oportunidad == $id2) {
                        $matriz->setId($row->id);
                        $success = $matriz->actualizar();
                        break;
                    }
                }
            } else {
                $success = $matriz->guardar();
            }
            break;
        case 'DA':
            $matriz = new MatrizDA();
            $matriz->setCodigo($codigo)
                   ->setValor($valor)
                   ->setIdDebilidad($id1)
                   ->setIdAmenaza($id2);
            if ($matriz->existeRelacion($id1, $id2)) {
                $rel = $matriz->obtenerPorCodigo($codigo);
                while ($row = $rel->fetch_object()) {
                    if ($row->id_debilidad == $id1 && $row->id_amenaza == $id2) {
                        $matriz->setIdMatrizDa($row->id_matriz_da);
                        $success = $matriz->actualizar();
                        break;
                    }
                }
            } else {
                $success = $matriz->guardar();
            }
            break;
    }

    echo json_encode(['success' => $success]);
    exit;
}
public function guardarMatrices() {
    if (!isset($_SESSION['plan_codigo'])) {
        $_SESSION['error_foda'] = 'No hay plan seleccionado.';
        header("Location: " . base_url . "foda/index");
        exit;
    }
    $codigo = $_SESSION['plan_codigo'];

    // Guardar FO
    if (isset($_POST['fo'])) {
        foreach ($_POST['fo'] as $id_fortaleza => $oportunidades) {
            foreach ($oportunidades as $id_oportunidad => $valor) {
                $matriz = new MatrizFO();
                $matriz->setCodigo($codigo);
                $matriz->setIdFortaleza($id_fortaleza);
                $matriz->setIdOportunidad($id_oportunidad);
                $matriz->setValor($valor);

                // Si existe, actualiza; si no, inserta
                if ($matriz->existeRelacion($id_fortaleza, $id_oportunidad)) {
                    // Busca el id para actualizar
                    $rel = $matriz->obtenerPorCodigo($codigo);
                    while ($row = $rel->fetch_object()) {
                        if ($row->id_fortaleza == $id_fortaleza && $row->id_oportunidad == $id_oportunidad) {
                            $matriz->setIdMatrizFo($row->id_matriz_fo);
                            $matriz->actualizar();
                            break;
                        }
                    }
                } else {
                    $matriz->guardar();
                }
            }
        }
    }

    // Guardar FA
    if (isset($_POST['fa'])) {
        foreach ($_POST['fa'] as $id_fortaleza => $amenazas) {
            foreach ($amenazas as $id_amenaza => $valor) {
                $matriz = new MatrizFA();
                $matriz->setCodigo($codigo);
                $matriz->setIdFortaleza($id_fortaleza);
                $matriz->setIdAmenaza($id_amenaza);
                $matriz->setValor($valor);

                if ($matriz->existeRelacion($id_fortaleza, $id_amenaza)) {
                    $rel = $matriz->obtenerPorCodigo($codigo);
                    while ($row = $rel->fetch_object()) {
                        if ($row->id_fortaleza == $id_fortaleza && $row->id_amenaza == $id_amenaza) {
                            $matriz->setIdMatrizFa($row->id_matriz_fa);
                            $matriz->actualizar();
                            break;
                        }
                    }
                } else {
                    $matriz->guardar();
                }
            }
        }
    }

    // Guardar DO
    if (isset($_POST['do'])) {
        foreach ($_POST['do'] as $id_debilidad => $oportunidades) {
            foreach ($oportunidades as $id_oportunidad => $valor) {
                $matriz = new MatrizDO();
                $matriz->setCodigo($codigo);
                $matriz->setIdDebilidad($id_debilidad);
                $matriz->setIdOportunidad($id_oportunidad);
                $matriz->setValor($valor);

                if ($matriz->existeRelacion($id_debilidad, $id_oportunidad)) {
                    $rel = $matriz->obtenerPorCodigo($codigo);
                    while ($row = $rel->fetch_object()) {
                        if ($row->id_debilidad == $id_debilidad && $row->id_oportunidad == $id_oportunidad) {
                            $matriz->setId($row->id);
                            $matriz->actualizar();
                            break;
                        }
                    }
                } else {
                    $matriz->guardar();
                }
            }
        }
    }

    // Guardar DA
    if (isset($_POST['da'])) {
        foreach ($_POST['da'] as $id_debilidad => $amenazas) {
            foreach ($amenazas as $id_amenaza => $valor) {
                $matriz = new MatrizDA();
                $matriz->setCodigo($codigo);
                $matriz->setIdDebilidad($id_debilidad);
                $matriz->setIdAmenaza($id_amenaza);
                $matriz->setValor($valor);

                if ($matriz->existeRelacion($id_debilidad, $id_amenaza)) {
                    $rel = $matriz->obtenerPorCodigo($codigo);
                    while ($row = $rel->fetch_object()) {
                        if ($row->id_debilidad == $id_debilidad && $row->id_amenaza == $id_amenaza) {
                            $matriz->setIdMatrizDa($row->id_matriz_da);
                            $matriz->actualizar();
                            break;
                        }
                    }
                } else {
                    $matriz->guardar();
                }
            }
        }
    }

    $_SESSION['exito_foda'] = 'Matrices FODA guardadas correctamente.';
    header("Location: " . base_url . "foda/index");
    exit;
}
private function filtrarPorUsuario($result, $id_usuario) {
    $elementos = [];
    while ($row = $result->fetch_object()) {
        if ($row->id_usuario == $id_usuario) {
            $elementos[] = $row;
        }
    }
    return $elementos;
}

private function calcularTotal($relaciones) {
    $total = 0;
    while ($relacion = $relaciones->fetch_object()) {
        $total += $relacion->valor;
    }
    return $total;
}

}
