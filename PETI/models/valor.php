<?php
require_once 'config/db.php';

class Valor {
    private $id_valor;
    private $valor;
    private $id_usuario;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    public function getIdValor() {
        return $this->id_valor;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdValor($id_valor) {
        $this->id_valor = $this->db->real_escape_string($id_valor);
    }

    public function setValor($valor) {
        $this->valor = $this->db->real_escape_string($valor);
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $this->db->real_escape_string($id_usuario);
    }

    public function guardar() {
        $sql = "INSERT INTO Valores (valor, id_usuario) VALUES ('{$this->getValor()}', {$this->getIdUsuario()})";
        return $this->db->query($sql);
    }

    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM Valores WHERE id_usuario = {$this->db->real_escape_string($id_usuario)} ORDER BY id_valor DESC";
        return $this->db->query($sql);
    }

    public function eliminar($id_valor) {
        $sql = "DELETE FROM Valores WHERE id_valor = {$this->db->real_escape_string($id_valor)}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE Valores SET valor = '{$this->getValor()}' WHERE id_valor = {$this->getIdValor()} AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }
}
