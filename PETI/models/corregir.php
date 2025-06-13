<?php
require_once 'config/db.php';

class Corregir {
    private $id_corregir;
    private $id_debilidad;
    private $corregir;
    private $codigo;
    private $id_usuario;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdCorregir() {
        return $this->id_corregir;
    }

    public function getIdDebilidad() {
        return $this->id_debilidad;
    }

    public function getCorregir() {
        return $this->corregir;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    // Setters
    public function setIdCorregir($id) {
        $this->id_corregir = intval($id);
        return $this;
    }

    public function setIdDebilidad($id_debilidad) {
        $this->id_debilidad = intval($id_debilidad);
        return $this;
    }

    public function setCorregir($corregir) {
        $this->corregir = $this->db->real_escape_string(trim($corregir));
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
        if (empty($this->corregir) || empty($this->codigo) || empty($this->id_usuario) || empty($this->id_debilidad)) {
            return false;
        }

        $sql = "INSERT INTO corregir VALUES(
            NULL, 
            {$this->getIdDebilidad()},
            '{$this->getCorregir()}', 
            '{$this->getCodigo()}', 
            {$this->getIdUsuario()}
        )";
        
        $guardado = $this->db->query($sql);
        
        if ($guardado) {
            $this->id_corregir = $this->db->insert_id;
            return true;
        }
        return false;
    }

    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM corregir 
                WHERE id_usuario = $id_usuario 
                ORDER BY id_corregir DESC";
        return $this->db->query($sql);
    }

    public function obtenerPorCodigo($codigo) {
        $sql = "SELECT * FROM corregir 
                WHERE codigo = '{$this->db->real_escape_string($codigo)}'";
        return $this->db->query($sql);
    }

    public function eliminar() {
        $sql = "DELETE FROM corregir 
                WHERE id_corregir = {$this->getIdCorregir()} 
                AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE corregir SET 
                corregir = '{$this->getCorregir()}'
                WHERE id_debilidad = {$this->getIdDebilidad()} 
                AND id_usuario = {$this->getIdUsuario()}
                AND codigo = '{$this->getCodigo()}'";
        $this->db->query($sql);
        return $this->db->affected_rows > 0;
    }

    public function obtenerPorDebilidadYUsuario($id_debilidad, $id_usuario) {
        $sql = "SELECT * FROM corregir 
                WHERE id_debilidad = $id_debilidad 
                AND id_usuario = $id_usuario 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado ? $resultado->fetch_object() : false;
    }
}
?>