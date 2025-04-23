<?php
require_once 'config/db.php';

class ObjetivoGeneral {
    private $id_general;
    private $objetivo;
    private $id_usuario;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdGeneral() {
        return $this->id_general;
    }

    public function getObjetivo() {
        return $this->objetivo;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    // Setters
    public function setIdGeneral($id_general) {
        $this->id_general = $this->db->real_escape_string($id_general);
    }

    public function setObjetivo($objetivo) {
        $this->objetivo = $this->db->real_escape_string($objetivo);
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $this->db->real_escape_string($id_usuario);
    }

    // CRUD Methods
    public function guardar() {
        $sql = "INSERT INTO Objetivo_general (objetivo, id_usuario) VALUES ('{$this->getObjetivo()}', {$this->getIdUsuario()})";
        return $this->db->query($sql);
    }

    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM Objetivo_general WHERE id_usuario = {$this->db->real_escape_string($id_usuario)} ORDER BY id_general DESC";
        return $this->db->query($sql);
    }

    public function obtenerPorId($id_general, $id_usuario) {
        $sql = "SELECT * FROM Objetivo_general WHERE id_general = {$this->db->real_escape_string($id_general)} AND id_usuario = {$this->db->real_escape_string($id_usuario)} LIMIT 1";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    public function eliminar($id_general) {
        // Primero eliminamos los objetivos específicos asociados
        $sqlDeleteEspecificos = "DELETE FROM Objetivo_especifico WHERE id_general = {$this->db->real_escape_string($id_general)}";
        $this->db->query($sqlDeleteEspecificos);
        
        // Luego eliminamos el objetivo general
        $sql = "DELETE FROM Objetivo_general WHERE id_general = {$this->db->real_escape_string($id_general)}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE Objetivo_general SET objetivo = '{$this->getObjetivo()}' WHERE id_general = {$this->getIdGeneral()} AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }
}