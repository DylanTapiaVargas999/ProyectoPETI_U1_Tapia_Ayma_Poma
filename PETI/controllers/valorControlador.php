<?php
require_once 'models/valor.php';

class valorControlador {

    public function index() {
        if (!isset($_SESSION['identity'])) {
            header("Location:" . base_url . "usuario/iniciarSesion");
            exit();
        }

        $id_usuario = $_SESSION['identity']->id;
        $valor = new Valor();
        $valores = $valor->obtenerPorUsuario($id_usuario);

        require_once 'views/valor/index.php';
    }

    public function guardar() {
        if (isset($_POST) && isset($_SESSION['identity'])) {
            $textoValor = isset($_POST['valor']) ? $_POST['valor'] : null;

            if ($textoValor) {
                $nuevoValor = new Valor();
                $nuevoValor->setValor($textoValor);
                $nuevoValor->setIdUsuario($_SESSION['identity']->id);

                $guardado = $nuevoValor->guardar();
                $_SESSION['valor_guardado'] = $guardado ? 'completado' : 'fallido';
            } else {
                $_SESSION['valor_guardado'] = 'fallido';
            }
        }

        header("Location:" . base_url . "valor/index");
    }

    public function eliminar() {
        if (isset($_GET['id']) && isset($_SESSION['identity'])) {
            $id_valor = (int) $_GET['id'];
            $valor = new Valor();
            $valor->eliminar($id_valor);

            $_SESSION['valor_eliminado'] = 'completado';
        }

        header("Location:" . base_url . "valor/index");
    }

    public function editar() {
        if (isset($_GET['id']) && isset($_SESSION['identity'])) {
            $id_valor = (int) $_GET['id'];
            $id_usuario = $_SESSION['identity']->id;
    
            $valor = new Valor();
            $resultado = $valor->obtenerPorUsuario($id_usuario);
    
            $valorActual = null;
            while ($v = $resultado->fetch_object()) {
                if ($v->id_valor == $id_valor) {
                    $valorActual = $v;
                    break;
                }
            }
    
            if ($valorActual) {
                // Pasar la variable a la vista
                require_once 'views/valor/editar.php';
            } else {
                $_SESSION['valor_error'] = 'No tienes permiso para editar este valor.';
                header("Location:" . base_url . "valor/index");
            }
        } else {
            header("Location:" . base_url . "valor/index");
        }
    }
    

    public function actualizar() {
        if (isset($_POST) && isset($_SESSION['identity'])) {
            $id_valor = isset($_POST['id_valor']) ? (int) $_POST['id_valor'] : null;
            $textoValor = isset($_POST['valor']) ? $_POST['valor'] : null;
            $id_usuario = $_SESSION['identity']->id;

            if ($id_valor && $textoValor) {
                $valor = new Valor();
                $valor->setIdValor($id_valor);
                $valor->setValor($textoValor);
                $valor->setIdUsuario($id_usuario);

                $actualizado = $valor->actualizar();

                $_SESSION['valor_actualizado'] = $actualizado ? 'completado' : 'fallido';
            }
        }

        header("Location:" . base_url . "valor/index");
    }
}
