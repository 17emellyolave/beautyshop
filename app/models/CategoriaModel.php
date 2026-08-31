<?php
class CategoriaModel extends Model {

    public function obtenerTodas() {
        $sql = "SELECT * FROM categorias ORDER BY id_categoria DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerActivas() {
        $sql = "SELECT * FROM categorias WHERE estado = 'activo' ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM categorias WHERE id_categoria = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function crear($datos) {
        $sql = "INSERT INTO categorias (nombre, descripcion, estado) VALUES (:nombre, :descripcion, :estado)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
        $stmt->bindValue(':estado', $datos['estado'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function actualizar($id, $datos) {
        $sql = "UPDATE categorias SET nombre = :nombre, descripcion = :descripcion, estado = :estado WHERE id_categoria = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
        $stmt->bindValue(':estado', $datos['estado'], PDO::PARAM_STR);
        return $stmt->execute();
    }
}
