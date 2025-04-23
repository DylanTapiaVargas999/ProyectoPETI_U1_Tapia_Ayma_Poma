<?php
require_once 'config/db.php';

class ObjetivoEspecifico {
    private $id_especifico;
    private $objetivo;
    private $id_general;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdEspecifico() {
        return $this->id_especifico;
    }

    public function getObjetivo() {
        return $this->objetivo;
    }

    public function getIdGeneral() {
        return $this->id_general;
    }

    // Setters
    public function setIdEspecifico($id_especifico) {
        $this->id_especifico = $this->db->real_escape_string($id_especifico);
    }

    public function setObjetivo($objetivo) {
        $this->objetivo = $this->db->real_escape_string($objetivo);
    }

    public function setIdGeneral($id_general) {
        $this->id_general = $this->db->real_escape_string($id_general);
    }

    // CRUD Methods
    public function guardar() {
        $sql = "INSERT INTO Objetivo_especifico (objetivo, id_general) VALUES ('{$this->getObjetivo()}', {$this->getIdGeneral()})";
        return $this->db->query($sql);
    }

    public function obtenerPorGeneral($id_general) {
        $sql = "SELECT * FROM Objetivo_especifico WHERE id_general = {$this->db->real_escape_string($id_general)} ORDER BY id_especifico DESC";
        return $this->db->query($sql);
    }

    public function obtenerPorId($id_especifico, $id_general) {
        $sql = "SELECT oe.* FROM Objetivo_especifico oe
                JOIN Objetivo_general og ON oe.id_general = og.id_general
                WHERE oe.id_especifico = {$this->db->real_escape_string($id_especifico)} 
                AND oe.id_general = {$this->db->real_escape_string($id_general)} 
                AND og.id_usuario = {$_SESSION['identity']->id}
                LIMIT 1";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    public function eliminar($id_especifico) {
        $sql = "DELETE FROM Objetivo_especifico WHERE id_especifico = {$this->db->real_escape_string($id_especifico)}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE Objetivo_especifico SET objetivo = '{$this->getObjetivo()}' WHERE id_especifico = {$this->getIdEspecifico()} AND id_general = {$this->getIdGeneral()}";
        return $this->db->query($sql);
    }
}