<?php
require_once 'models/usuario.php';

class usuarioControlador {

    public $estaLogueado;
    
    public function index(){
        echo "Controlador de Usuario, Acción index";
        require_once 'index.php';
    }

    public function setEstaLogueado($estaLogueado){
        $this->estaLogueado = $estaLogueado;
    }

    public function getEstaLogueado(){
        return $this->estaLogueado;
    }

    public function guardar(){
        if(isset($_POST)){
            $nombre = isset($_POST['nombre-registro']) ? $_POST['nombre-registro'] : false;
            $apellido = isset($_POST['apellido-registro']) ? $_POST['apellido-registro'] : false;
            $correo = isset($_POST['correo-registro']) ? $_POST['correo-registro'] : false;
            $clave = isset($_POST['clave-registro']) ? $_POST['clave-registro'] : false;
            
            if($nombre && $apellido && $correo && $clave){
                $usuario = new Usuario();
                $usuario->setNombre($_POST['nombre-registro']);
                $usuario->setApellido($_POST['apellido-registro']);
                $usuario->setCorreo($_POST['correo-registro']);
                $usuario->setClave($_POST['clave-registro']);
                $guardar = $usuario->guardar();

                if($guardar){
                    $_SESSION['registro'] = 'completado';
                    require_once 'views/usuario/registroCompletado.php';
                } else {
                    require_once 'views/usuario/registroCompletado.php';
                    $_SESSION['registro'] = 'fallido';
                }
            } else {
                require_once 'views/usuario/registroCompletado.php';
                $_SESSION['registro'] = 'fallido';
            }
        } else {
            require_once 'views/usuario/registroCompletado.php';
            $_SESSION['registro'] = 'fallido';
        }
        exit(header("Location:".base_url));
    }

    public function iniciarSesion(){
        if(isset($_POST)){
            // Identificar usuario
            $usuario = new Usuario();
            $usuario->setCorreo($_POST['correo-login']);
            $usuario->setClave($_POST['clave']);
            
            $identidad = $usuario->iniciarSesion();

            // Crear sesión para mantener al usuario logueado
            if($identidad && is_object($identidad)){
                $_SESSION['identity'] = $identidad;
                header("Location:".base_url);

                if($identidad->rol == 'admin'){
                    $_SESSION['admin'] = true;
                }
            } else {
                $_SESSION['error_login'] = 'Falló la identificación';
                echo '¡Falló la identificación!';
            }
        }
    }

    public function perfil(){
        // 1. Verifica si el usuario ha iniciado sesión
        if (!isset($_SESSION['identity'])) {
            header("Location:".base_url."usuario/iniciarSesion");
            exit();
        }
    
        // 2. Si está autenticado, obtiene los datos del usuario desde la sesión
        $usuario = $_SESSION['identity'];
    
        // 3. Carga la vista de perfil del usuario
        require_once 'views/usuario/perfil.php';
    }
    public function editarPerfil(){
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['identity'])) {
            header("Location:".base_url."usuario/iniciarSesion");
            exit();
        }

        // Obtener los datos del usuario de la sesión
        $usuario = $_SESSION['identity'];

        // Aquí puedes cargar la vista de perfil
        require_once 'views/usuario/editarPerfil.php';
    }


    public function cerrarSesion(){
        if(isset($_SESSION['identity'])){
            unset($_SESSION['identity']);
        }

        if(isset($_SESSION['admin'])){
            unset($_SESSION['admin']);            
        }

        header("Location:".base_url);
    }

    public function actualizarPerfil() {
        if (isset($_POST)) {
            // Obtener datos del formulario y sanitizarlos
            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            $apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_STRING);
            $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    
            // Verificar que los datos no estén vacíos
            if ($nombre && $apellido && $correo) {
                $usuario = new Usuario();
                $usuario->setId($_SESSION['identity']->id);
                $usuario->setNombre($nombre);
                $usuario->setApellido($apellido);
                $usuario->setCorreo($correo);
    
                // Procesar la imagen si se ha subido una nueva
                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
                    $imagen = $_FILES['imagen'];
                    $nombreImagen = time() . "-" . $imagen['name'];
                    $rutaDestino = 'assets/img/perfiles/' . $nombreImagen;
    
                    // Verificar tipo y tamaño de imagen
                    $tipoImagen = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                    $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif'];
                    $maxSize = 2 * 1024 * 1024; // 2 MB
    
                    if (in_array($tipoImagen, $tiposPermitidos) && $imagen['size'] <= $maxSize) {
                        // Mover la imagen a la carpeta de destino
                        if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                            $usuario->setImagen($nombreImagen);
    
                            // Eliminar la imagen antigua si existe
                            if (!empty($_SESSION['identity']->imagen)) {
                                unlink('assets/img/perfiles/' . $_SESSION['identity']->imagen);
                            }
    
                            $_SESSION['identity']->imagen = $nombreImagen; // Actualizar imagen en sesión
                        } else {
                            $_SESSION['error_imagen'] = 'Error al mover la imagen.';
                        }
                    } else {
                        $_SESSION['error_imagen'] = 'Formato de imagen no permitido o el tamaño es demasiado grande.';
                    }
                }
    
                // Guardar los cambios en la base de datos
                $actualizar = $usuario->actualizar();
    
                if ($actualizar) {
                    // Actualizar los datos de la sesión
                    $_SESSION['identity']->nombre = $nombre;
                    $_SESSION['identity']->apellido = $apellido;
                    $_SESSION['identity']->correo = $correo;
    
                    $_SESSION['perfil_actualizado'] = 'completado';
                } else {
                    $_SESSION['perfil_actualizado'] = 'fallido';
                }
            } else {
                $_SESSION['perfil_actualizado'] = 'fallido';
            }
    
            header("Location: " . base_url . "usuario/perfil");
            exit; // Asegúrate de salir después de la redirección
        }
    }


} // fin de la clase
