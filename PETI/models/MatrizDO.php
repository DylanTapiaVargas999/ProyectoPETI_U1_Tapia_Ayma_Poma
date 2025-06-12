<?php
require_once 'config/db.php';

class MatrizDO {
    private $id_matriz_do;
    private $valor;
    private $codigo;
    private $id_debilidad;
    private $id_oportunidad;
    private $db;

    public function __construct() {
        $this->db = Database::conexion();
    }

    // Getters
    public function getIdMatrizDo() {
        return $this->id_matriz_do;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getIdDebilidad() {
        return $this->id_debilidad;
    }

    public function getIdOportunidad() {
        return $this->id_oportunidad;
    }

    // Setters
    public function setIdMatrizDo($id) {
        $this->id_matriz_do = intval($id);
        return $this;
    }

    public function setValor($valor) {
        $this->valor = intval($valor) >= 0 && intval($valor) <= 4 ? intval($valor) : 0;
        return $this;
    }

    public function setCodigo($codigo) {
        $this->codigo = $this->db->real_escape_string(trim($codigo));
        return $this;
    }

    public function setIdDebilidad($id_debilidad) {
        $this->id_debilidad = intval($id_debilidad);
        return $this;
    }

    public function setIdOportunidad($id_oportunidad) {
        $this->id_oportunidad = intval($id_oportunidad);
        return $this;
    }

    // Métodos CRUD
    public function guardar() {
        if (empty($this->id_debilidad) || empty($this->id_oportunidad)) {
            return false;
        }

        if (empty($this->codigo) && isset($_SESSION['plan_codigo'])) {
            $this->codigo = $_SESSION['plan_codigo'];
        }

        $sql = "INSERT INTO matriz_do VALUES(
            NULL, 
            {$this->getValor()}, 
            '{$this->getCodigo()}', 
            {$this->getIdDebilidad()}, 
            {$this->getIdOportunidad()}
        )";
        
        $guardado = $this->db->query($sql);
        
        if ($guardado) {
            $this->id_matriz_do = $this->db->insert_id;
            return true;
        }
        return false;
    }

    public function obtenerPorCodigo($codigo) {
        $sql = "SELECT * FROM matriz_do 
                WHERE codigo = '{$this->db->real_escape_string($codigo)}'";
        return $this->db->query($sql);
    }

    public function eliminar() {
        $sql = "DELETE FROM matriz_do 
                WHERE id_matriz_do = {$this->getIdMatrizDo()}";
        return $this->db->query($sql);
    }

    public function actualizar() {
        $sql = "UPDATE matriz_do SET 
                valor = {$this->getValor()}
                WHERE id_matriz_do = {$this->getIdMatrizDo()}";
        return $this->db->query($sql);
    }

    public function obtenerPorId($id_matriz_do) {
        $sql = "SELECT * FROM matriz_do 
                WHERE id_matriz_do = $id_matriz_do 
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado ? $resultado->fetch_object() : false;
    }

    public function existeRelacion($id_debilidad, $id_oportunidad) {
        $sql = "SELECT id_matriz_do FROM matriz_do 
                WHERE id_debilidad = $id_debilidad 
                AND id_oportunidad = $id_oportunidad 
                AND codigo = '{$this->codigo}'
                LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado && $resultado->num_rows > 0;
    }
}
?>