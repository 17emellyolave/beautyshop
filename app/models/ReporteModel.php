<?php
class ReporteModel extends Model {

    // KPIs Generales del rango seleccionado
    public function obtenerKPIs(string $fechaInicio, string $fechaFin): array {
        $sql = "SELECT 
                    COALESCE(SUM(total), 0) AS ingresos_totales,
                    COUNT(id_pedido) AS total_pedidos,
                    COALESCE(AVG(total), 0) AS ticket_promedio
                FROM pedidos 
                WHERE estado IN ('pagado', 'enviado', 'entregado') 
                  AND DATE(fecha_pedido) BETWEEN :inicio AND :fin";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':inicio', $fechaInicio);
        $stmt->bindValue(':fin', $fechaFin);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Top de productos más vendidos en el periodo
    public function obtenerTopProductos(string $fechaInicio, string $fechaFin, int $limite = 5): array {
        $sql = "SELECT 
                    p.nombre,
                    c.nombre AS categoria,
                    SUM(dp.cantidad) AS unidades_vendidas,
                    SUM(dp.subtotal) AS total_recaudado
                FROM detalle_pedidos dp
                INNER JOIN pedidos pe ON dp.id_pedido = pe.id_pedido
                INNER JOIN productos p ON dp.id_producto = p.id_producto
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                WHERE pe.estado IN ('pagado', 'enviado', 'entregado')
                  AND DATE(pe.fecha_pedido) BETWEEN :inicio AND :fin
                GROUP BY p.id_producto, p.nombre, c.nombre
                ORDER BY unidades_vendidas DESC
                LIMIT :limite";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':inicio', $fechaInicio);
        $stmt->bindValue(':fin', $fechaFin);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Ventas agrupadas por Categoría
    public function obtenerVentasPorCategoria(string $fechaInicio, string $fechaFin): array {
        $sql = "SELECT 
                    c.nombre AS categoria,
                    SUM(dp.cantidad) AS total_unidades,
                    SUM(dp.subtotal) AS total_ventas
                FROM detalle_pedidos dp
                INNER JOIN pedidos pe ON dp.id_pedido = pe.id_pedido
                INNER JOIN productos p ON dp.id_producto = p.id_producto
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                WHERE pe.estado IN ('pagado', 'enviado', 'entregado')
                  AND DATE(pe.fecha_pedido) BETWEEN :inicio AND :fin
                GROUP BY c.id_categoria, c.nombre
                ORDER BY total_ventas DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':inicio', $fechaInicio);
        $stmt->bindValue(':fin', $fechaFin);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Listado detallado de transacciones
    public function obtenerDetalleVentas(string $fechaInicio, string $fechaFin): array {
        $sql = "SELECT 
                    pe.id_pedido,
                    pe.fecha_pedido,
                    u.nombre AS cliente,
                    pe.total,
                    pe.estado
                FROM pedidos pe
                INNER JOIN usuarios u ON pe.id_usuario = u.id_usuario
                WHERE DATE(pe.fecha_pedido) BETWEEN :inicio AND :fin
                ORDER BY pe.fecha_pedido DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':inicio', $fechaInicio);
        $stmt->bindValue(':fin', $fechaFin);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}