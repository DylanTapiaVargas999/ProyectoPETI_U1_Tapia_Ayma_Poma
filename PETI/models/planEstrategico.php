<?php
require_once 'config/db.php';

class PlanEstrategico {
    private $id;
    private $codigo;
    private $titulo;
    private $id_usuario;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    // Setters
    public function setId($id) {
        $this->id = $this->db->real_escape_string($id);
    }

    public function setCodigo($codigo) {
        $this->codigo = $this->db->real_escape_string($codigo);
    }

    public function setTitulo($titulo) {
        $this->titulo = $this->db->real_escape_string($titulo);
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $this->db->real_escape_string($id_usuario);
    }

    // Guardar nuevo plan estratégico
    public function guardar() {
        $sql = "INSERT INTO plan_estrategico (codigo, titulo, id_usuario)
                VALUES ('{$this->getCodigo()}', '{$this->getTitulo()}', {$this->getIdUsuario()})";
        return $this->db->query($sql);
    }

    // Obtener todos los planes por usuario
    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT * FROM plan_estrategico WHERE id_usuario = {$this->db->real_escape_string($id_usuario)} ORDER BY id DESC";
        return $this->db->query($sql);
    }

    // Eliminar un plan estratégico
    public function eliminar($id) {
        $sql = "DELETE FROM plan_estrategico WHERE id = {$this->db->real_escape_string($id)}";
        return $this->db->query($sql);
    }

    // Actualizar plan estratégico
    public function actualizar() {
        $sql = "UPDATE plan_estrategico 
                SET codigo = '{$this->getCodigo()}', titulo = '{$this->getTitulo()}'
                WHERE id = {$this->getId()} AND id_usuario = {$this->getIdUsuario()}";
        return $this->db->query($sql);
    }
}
