<?php
require_once 'config/db.php';

class Vision {
    private $id_vision;
    private $vision;
    private $id_usuario;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdVision() {
        return $this->id_vision;
    }

    public function getVision() {
        return $this->vision;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    // Setters
    public function setIdVision($id_vision) {
        $this->id_vision = $this->db->real_escape_string($id_vision);
    }

    public function setVision($vision) {
        $this->vision = $this->db->real_escape_string($vision);
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $this->db->real_escape_string($id_usuario);
    }

    // Guardar nueva visión
    public function guardar() {
        $sql = "INSERT INTO Vision (vision, id_usuario) VALUES ('{$this->getVision()}', {$this->getIdUsuario()})";
        $resultado = $this->db->query($sql);
        return $resultado;
    }

    // Obtener visiones por usuario
    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM Vision WHERE id_usuario = {$this->db->real_escape_string($id_usuario)} ORDER BY id_vision DESC";
        $result = $this->db->query($sql);
        return $result;
    }

    // Eliminar visión
    public function eliminar($id_vision) {
        $sql = "DELETE FROM Vision WHERE id_vision = {$this->db->real_escape_string($id_vision)}";
        return $this->db->query($sql);
    }

    // Actualizar visión
    public function actualizar() {
        $sql = "UPDATE Vision SET vision = '{$this->getVision()}' WHERE id_vision = {$this->getIdVision()} AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }
}
