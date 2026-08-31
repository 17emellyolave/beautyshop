<?php
class UsuarioModel extends Model {

    public function obtenerPorCorreo($correo) {
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

    public function registrar($datos) {
        $sql = "INSERT INTO usuarios (id_rol, nombre, correo, password, telefono, direccion, estado) 
                VALUES (2, :nombre, :correo, :password, :telefono, :direccion, 'activo')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindValue(':correo', $datos['correo'], PDO::PARAM_STR);
        $stmt->bindValue(':password', $datos['password'], PDO::PARAM_STR);
        $stmt->bindValue(':telefono', $datos['telefono'], PDO::PARAM_STR);
        $stmt->bindValue(':direccion', $datos['direccion'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function existeCorreo($correo) {
        $sql = "SELECT id_usuario FROM usuarios WHERE correo = :correo LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
}
