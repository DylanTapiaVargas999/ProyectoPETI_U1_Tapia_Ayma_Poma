<?php

class Usuario {
    private $id;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    private $rol;
    private $imagen;
    private $db;

    public function __construct(){
        $this->db = Database::conexion();
    }

    /**
     * Obtener el valor de id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Establecer el valor de id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Obtener el valor de nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Establecer el valor de nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $this->db->real_escape_string($nombre);

        return $this;
    }

    /**
     * Obtener el valor de apellido
     */ 
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Establecer el valor de apellido
     *
     * @return  self
     */ 
    public function setApellido($apellido)
    {
        $this->apellido = $this->db->real_escape_string($apellido);

        return $this;
    }

    /**
     * Obtener el valor de correo
     */ 
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Establecer el valor de correo
     *
     * @return  self
     */ 
    public function setCorreo($correo)
    {
        $this->correo = $this->db->real_escape_string($correo);

        return $this;
    }

    /**
     * Obtener el valor de clave
     */ 
    public function getClave()
    {
        return password_hash($this->db->real_escape_string($this->clave), PASSWORD_BCRYPT, ['cost'=>4]);
    }

    /**
     * Establecer el valor de clave
     *
     * @return  self
     */ 
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Obtener el valor de rol
     */ 
    public function getRol()
    {
        return $this->db->real_escape_string($this->rol);
    }

    /**
     * Establecer el valor de rol
     *
     * @return  self
     */ 
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Obtener el valor de imagen
     */ 
    public function getImagen()
    {
        return $this->db->real_escape_string($this->imagen);
    }

    /**
     * Establecer el valor de imagen
     *
     * @return  self
     */ 
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function guardar(){
        $sql = "INSERT INTO usuario VALUES(NULL, '{$this->getNombre()}', '{$this->getApellido()}', '{$this->getCorreo()}', '{$this->getClave()}', 'usuario', NULL)";
        $guardar = $this->db->query($sql);

        $resultado = false;

        if($guardar){
            $resultado = true;
        }

        return $resultado;
    }

    public function iniciarSesion(){
        $resultado = false;

        $correo = $this->correo;
        $clave = $this->clave;

        // Verificar si el usuario existe
        $sql = "SELECT * FROM usuario WHERE correo = '$correo'";
        $iniciarSesion = $this->db->query($sql);

        if($iniciarSesion && $iniciarSesion->num_rows == 1){            
            $usuario = $iniciarSesion->fetch_object(); // Convierte la respuesta de la BD en un objeto

            // Verificar la clave
            $verificar = password_verify($clave, $usuario->clave);
            if($verificar){
                $resultado = $usuario;
            } 
        } 

        return $resultado;
    }

    public function actualizar() {
        // Verificar si el correo ya está en uso por otro usuario
        $sqlVerificar = "SELECT * FROM usuario WHERE correo = '{$this->getCorreo()}' AND id != {$this->getId()}";
        $verificarCorreo = $this->db->query($sqlVerificar);
    
        if ($verificarCorreo && $verificarCorreo->num_rows > 0) {
            return false; // El correo ya está en uso por otro usuario
        }
    
        $sql = "UPDATE usuario SET 
                    nombre = '{$this->getNombre()}', 
                    apellido = '{$this->getApellido()}', 
                    correo = '{$this->getCorreo()}'";
    
        if (!empty($this->imagen)) {
            $sql .= ", imagen = '{$this->getImagen()}'";
        }
        
        $sql .= " WHERE id = {$this->getId()}";
    
        $actualizar = $this->db->query($sql);
    
        return $actualizar ? true : false;
    }
    
}
