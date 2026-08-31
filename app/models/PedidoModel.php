<?php
class PedidoModel extends Model {

    // Crear el pedido y descontar el stock usando transacciones SQL
    public function crearPedido($datosPedido, $carrito) {
        try {
            $this->db->beginTransaction();

            // 1. Insertar el encabezado del pedido
            $sqlPedido = "INSERT INTO pedidos (id_usuario, total, estado, direccion_envio) 
                         VALUES (:id_usuario, :total, 'pendiente', :direccion_envio)";
            $stmt = $this->db->prepare($sqlPedido);
            $stmt->bindValue(':id_usuario', $datosPedido['id_usuario'], PDO::PARAM_INT);
            $stmt->bindValue(':total', $datosPedido['total']);
            $stmt->bindValue(':direccion_envio', $datosPedido['direccion_envio'], PDO::PARAM_STR);
            $stmt->execute();

            $idPedido = (int)$this->db->lastInsertId();

            // 2. Sentencias preparadas para detalle y descuento de stock
            $sqlDetalle = "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio_unitario, subtotal) 
                          VALUES (:id_pedido, :id_producto, :cantidad, :precio_unitario, :subtotal)";
            $stmtDetalle = $this->db->prepare($sqlDetalle);

            // Uso de marcadores `:cant1` y `:cant2` para evitar errores de binding en PDO
            $sqlStock = "UPDATE productos SET stock = stock - :cant1 WHERE id_producto = :id_producto AND stock >= :cant2";
            $stmtStock = $this->db->prepare($sqlStock);

            foreach ($carrito as $item) {
                $subtotal = $item['precio'] * $item['cantidad'];

                // Insertar Detalle
                $stmtDetalle->bindValue(':id_pedido', $idPedido, PDO::PARAM_INT);
                $stmtDetalle->bindValue(':id_producto', $item['id_producto'], PDO::PARAM_INT);
                $stmtDetalle->bindValue(':cantidad', $item['cantidad'], PDO::PARAM_INT);
                $stmtDetalle->bindValue(':precio_unitario', $item['precio']);
                $stmtDetalle->bindValue(':subtotal', $subtotal);
                $stmtDetalle->execute();

                // Actualizar Stock de Producto
                $stmtStock->bindValue(':cant1', $item['cantidad'], PDO::PARAM_INT);
                $stmtStock->bindValue(':cant2', $item['cantidad'], PDO::PARAM_INT);
                $stmtStock->bindValue(':id_producto', $item['id_producto'], PDO::PARAM_INT);
                $stmtStock->execute();

                // Si no se actualizó ninguna fila, es porque el stock era insuficiente
                if ($stmtStock->rowCount() === 0) {
                    $this->db->rollBack();
                    return false;
                }
            }

            $this->db->commit();
            return $idPedido;

        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }

    // Historial de pedidos por cliente
    public function obtenerPorUsuario($idUsuario) {
        $sql = "SELECT * FROM pedidos WHERE id_usuario = :id_usuario ORDER BY id_pedido DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}