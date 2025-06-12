<?php
require_once 'config/db.php';

class Mantener {
    private $id_mantener;
    private $mantener;
    private $codigo;
    private $id_usuario;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdMantener() {
        return $this->id_mantener;
    }

    public function getMantener() {
        return $this->mantener;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    // Setters
    public function setIdMantener($id) {
        $this->id_mantener = intval($id);
        return $this;
    }

    public function setMantener($mantener) {
        $this->mantener = $this->db->real_escape_string(trim($mantener));
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
        if (empty($this->mantener) || empty($this->codigo) || empty($this->id_usuario)) {
            return false;
        }

        $sql = "INSERT INTO mantener VALUES(
            NULL, 
            '{$this->getMantener()}', 
            '{$this->getCodigo()}', 
            {$this->getIdUsuario()}
        )";
        
        $guardado = $this->db->query($sql);
        
        if ($guardado) {
            $this->id_mantener = $this->db->insert_id;
            return true;
        }
        return false;
    }

    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM mantener 
                WHERE id_usuario = $id_usuario 
                ORDER BY id_mantener DESC";
        return $this->db->query($sql);
    }

    public function obtenerPorCodigo($codigo) {
        $sql = "SELECT * FROM mantener 
                WHERE codigo = '{$this->db->real_escape_string($codigo)}'";
        return $this->db->query($sql);
    }

    public function eliminar() {
        $sql = "DELETE FROM mantener 
                WHERE id_mantener = {$this->getIdMantener()} 
                AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE mantener SET 
                mantener = '{$this->getMantener()}'
                WHERE id_mantener = {$this->getIdMantener()} 
                AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }

    public function obtenerPorIdYUsuario($id_mantener, $id_usuario) {
        $sql = "SELECT * FROM mantener 
                WHERE id_mantener = $id_mantener 
                AND id_usuario = $id_usuario 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado ? $resultado->fetch_object() : false;
    }
}
?>