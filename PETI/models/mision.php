<?php
require_once 'config/db.php';

class Mision {
    private $id_mision;
    private $mision;
    private $id_usuario;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdMision() {
        return $this->id_mision;
    }

    public function getMision() {
        return $this->mision;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    // Setters
    public function setIdMision($id_mision) {
        $this->id_mision = $this->db->real_escape_string($id_mision);
    }

    public function setMision($mision) {
        $this->mision = $this->db->real_escape_string($mision);
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $this->db->real_escape_string($id_usuario);
    }

    // Guardar nueva misión
    public function guardar() {
        $sql = "INSERT INTO Mision (mision, id_usuario) VALUES ('{$this->getMision()}', {$this->getIdUsuario()})";
        $resultado = $this->db->query($sql);
        return $resultado;
    }

    // Obtener misiones por usuario
    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM Mision WHERE id_usuario = {$this->db->real_escape_string($id_usuario)} ORDER BY id_mision DESC";
        $result = $this->db->query($sql);
        return $result;
    }

    // Eliminar misión
    public function eliminar($id_mision) {
        $sql = "DELETE FROM Mision WHERE id_mision = {$this->db->real_escape_string($id_mision)}";
        return $this->db->query($sql);
    }

    // Actualizar misión
    public function actualizar() {
        $sql = "UPDATE Mision SET mision = '{$this->getMision()}' WHERE id_mision = {$this->getIdMision()} AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }
}
