<?php
require_once 'config/db.php';

class Uen {
    private $id_uen;
    private $uen;
    private $id_usuario;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdUen() {
        return $this->id_uen;
    }

    public function getUen() {
        return $this->uen;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    // Setters
    public function setIdUen($id_uen) {
        $this->id_uen = $this->db->real_escape_string($id_uen);
    }

    public function setUen($uen) {
        $this->uen = $this->db->real_escape_string($uen);
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $this->db->real_escape_string($id_usuario);
    }

    // Guardar nueva UEN
    public function guardar() {
        $sql = "INSERT INTO UEN (uen, id_usuario) VALUES ('{$this->getUen()}', {$this->getIdUsuario()})";
        $resultado = $this->db->query($sql);
        return $resultado;
    }

    // Obtener UENs por usuario
    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM UEN WHERE id_usuario = {$this->db->real_escape_string($id_usuario)} ORDER BY id_uen DESC";
        $result = $this->db->query($sql);
        return $result;
    }

    // Obtener UEN específica por ID y usuario
    public function obtenerPorId($id_uen, $id_usuario) {
        $sql = "SELECT * FROM UEN WHERE id_uen = {$this->db->real_escape_string($id_uen)} AND id_usuario = {$this->db->real_escape_string($id_usuario)} LIMIT 1";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    // Eliminar UEN
    public function eliminar($id_uen) {
        $sql = "DELETE FROM UEN WHERE id_uen = {$this->db->real_escape_string($id_uen)}";
        return $this->db->query($sql);
    }

    // Actualizar UEN
    public function actualizar() {
        $sql = "UPDATE UEN SET uen = '{$this->getUen()}' WHERE id_uen = {$this->getIdUen()} AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }
}