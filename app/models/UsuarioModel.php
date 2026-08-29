<?php
class UsuarioModel extends Model {

    // Buscar un usuario activo por su correo electrónico
    public function obtenerPorCorreo(string $correo): array|false {
        $sql = "SELECT u.*, r.nombre AS rol_nombre 
                FROM usuarios u 
                INNER JOIN roles r ON u.id_rol = r.id_rol 
                WHERE u.correo = :correo AND u.estado = 'activo' 
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Registrar un nuevo cliente (Rol 2 = Cliente por defecto)
    public function registrar(array $datos): bool {
        $sql = "INSERT INTO usuarios (id_rol, nombre, correo, password, telefono, direccion, estado) 
                VALUES (2, :nombre, :correo, :password, :telefono, :direccion, 'activo')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindValue(':correo', $datos['correo'], PDO::PARAM_STR);
        $stmt->bindValue(':password', $datos['password'], PDO::PARAM_STR); // Hash encriptado
        $stmt->bindValue(':telefono', $datos['telefono'], PDO::PARAM_STR);
        $stmt->bindValue(':direccion', $datos['direccion'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Validar si un correo ya está registrado en la base de datos
    public function existeCorreo(string $correo): bool {
        $sql = "SELECT id_usuario FROM usuarios WHERE correo = :correo LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
}
