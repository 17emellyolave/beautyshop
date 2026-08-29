<?php
class ProductoModel extends Model {

    public function obtenerTodos(): array {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre 
                FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria 
                ORDER BY p.id_producto DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id): array|false {
        $sql = "SELECT * FROM productos WHERE id_producto = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function crear(array $datos): bool {
        $sql = "INSERT INTO productos (id_categoria, nombre, descripcion, precio, stock, imagen, estado) 
                VALUES (:id_categoria, :nombre, :descripcion, :precio, :stock, :imagen, :estado)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_categoria', $datos['id_categoria'], PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
        $stmt->bindValue(':precio', $datos['precio']);
        $stmt->bindValue(':stock', $datos['stock'], PDO::PARAM_INT);
        $stmt->bindValue(':imagen', $datos['imagen'], PDO::PARAM_STR);
        $stmt->bindValue(':estado', $datos['estado'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function actualizar(int $id, array $datos): bool {
        $sql = "UPDATE productos 
                SET id_categoria = :id_categoria, nombre = :nombre, descripcion = :descripcion, 
                    precio = :precio, stock = :stock, imagen = :imagen, estado = :estado 
                WHERE id_producto = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':id_categoria', $datos['id_categoria'], PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
        $stmt->bindValue(':precio', $datos['precio']);
        $stmt->bindValue(':stock', $datos['stock'], PDO::PARAM_INT);
        $stmt->bindValue(':imagen', $datos['imagen'], PDO::PARAM_STR);
        $stmt->bindValue(':estado', $datos['estado'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Obtener productos destacados (los más recientes activos)
    public function obtenerDestacados(int $limite = 3): array {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre 
                FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria 
                WHERE p.estado = 'activo' 
                ORDER BY p.id_producto DESC 
                LIMIT :limite";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
