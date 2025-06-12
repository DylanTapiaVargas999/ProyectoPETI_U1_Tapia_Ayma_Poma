<?php
require_once 'config/db.php';

class Afrontar {
    private $id_afrontar;
    private $afrontar;
    private $codigo;
    private $id_usuario;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdAfrontar() {
        return $this->id_afrontar;
    }

    public function getAfrontar() {
        return $this->afrontar;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    // Setters
    public function setIdAfrontar($id) {
        $this->id_afrontar = intval($id);
        return $this;
    }

    public function setAfrontar($afrontar) {
        $this->afrontar = $this->db->real_escape_string(trim($afrontar));
        return $this;
    }

    public function setCodigo($codigo) {
        $this->codigo = $this->db->real_escape_string(trim($codigo));
        return $this;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = intval($id_usuario);
        return $this;
    }

    // Métodos CRUD
    public function guardar() {
        if (empty($this->afrontar) || empty($this->codigo) || empty($this->id_usuario)) {
            return false;
        }

        $sql = "INSERT INTO afrontar VALUES(
            NULL, 
            '{$this->getAfrontar()}', 
            '{$this->getCodigo()}', 
            {$this->getIdUsuario()}
        )";
        
        $guardado = $this->db->query($sql);
        
        if ($guardado) {
            $this->id_afrontar = $this->db->insert_id;
            return true;
        }
        return false;
    }

    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM afrontar 
                WHERE id_usuario = $id_usuario 
                ORDER BY id_afrontar DESC";
        return $this->db->query($sql);
    }

    public function obtenerPorCodigo($codigo) {
        $sql = "SELECT * FROM afrontar 
                WHERE codigo = '{$this->db->real_escape_string($codigo)}'";
        return $this->db->query($sql);
    }

    public function eliminar() {
        $sql = "DELETE FROM afrontar 
                WHERE id_afrontar = {$this->getIdAfrontar()} 
                AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE afrontar SET 
                afrontar = '{$this->getAfrontar()}'
                WHERE id_afrontar = {$this->getIdAfrontar()} 
                AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }

    public function obtenerPorIdYUsuario($id_afrontar, $id_usuario) {
        $sql = "SELECT * FROM afrontar 
                WHERE id_afrontar = $id_afrontar 
                AND id_usuario = $id_usuario 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado ? $resultado->fetch_object() : false;
    }
}
?>