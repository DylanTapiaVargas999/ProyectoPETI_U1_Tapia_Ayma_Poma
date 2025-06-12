<?php
require_once 'config/db.php';

class Explotar {
    private $id_explotar;
    private $explotar;
    private $codigo;
    private $id_usuario;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdExplotar() {
        return $this->id_explotar;
    }

    public function getExplotar() {
        return $this->explotar;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    // Setters
    public function setIdExplotar($id) {
        $this->id_explotar = intval($id);
        return $this;
    }

    public function setExplotar($explotar) {
        $this->explotar = $this->db->real_escape_string(trim($explotar));
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
        if (empty($this->explotar) || empty($this->codigo) || empty($this->id_usuario)) {
            return false;
        }

        $sql = "INSERT INTO explotar VALUES(
            NULL, 
            '{$this->getExplotar()}', 
            '{$this->getCodigo()}', 
            {$this->getIdUsuario()}
        )";
        
        $guardado = $this->db->query($sql);
        
        if ($guardado) {
            $this->id_explotar = $this->db->insert_id;
            return true;
        }
        return false;
    }

    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM explotar 
                WHERE id_usuario = $id_usuario 
                ORDER BY id_explotar DESC";
        return $this->db->query($sql);
    }

    public function obtenerPorCodigo($codigo) {
        $sql = "SELECT * FROM explotar 
                WHERE codigo = '{$this->db->real_escape_string($codigo)}'";
        return $this->db->query($sql);
    }

    public function eliminar() {
        $sql = "DELETE FROM explotar 
                WHERE id_explotar = {$this->getIdExplotar()} 
                AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE explotar SET 
                explotar = '{$this->getExplotar()}'
                WHERE id_explotar = {$this->getIdExplotar()} 
                AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }

    public function obtenerPorIdYUsuario($id_explotar, $id_usuario) {
        $sql = "SELECT * FROM explotar 
                WHERE id_explotar = $id_explotar 
                AND id_usuario = $id_usuario 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado ? $resultado->fetch_object() : false;
    }
}
?>