-- =============================================================================
-- BASE DE DATOS: BeautyShop Online
-- Motor: MySQL / MariaDB | Codificación: utf8mb4_unicode_ci
-- =============================================================================

CREATE DATABASE IF NOT EXISTS `beautyshop_db` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `beautyshop_db`;

-- -----------------------------------------------------------------------------
-- 1. TABLA: roles
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `roles` (
    `id_rol` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(50) NOT NULL UNIQUE,
    `descripcion` VARCHAR(255) NULL,
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 2. TABLA: usuarios
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id_usuario` INT AUTO_INCREMENT PRIMARY KEY,
    `id_rol` INT NOT NULL,
    `nombre` VARCHAR(100) NOT NULL,
    `correo` VARCHAR(150) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `telefono` VARCHAR(20) NULL,
    `direccion` VARCHAR(255) NULL,
    `estado` ENUM('activo', 'inactivo') DEFAULT 'activo',
    `fecha_registro` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_usuarios_roles` 
        FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) 
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_usuarios_correo` ON `usuarios` (`correo`);

-- -----------------------------------------------------------------------------
-- 3. TABLA: categorias
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categorias` (
    `id_categoria` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL UNIQUE,
    `descripcion` TEXT NULL,
    `estado` ENUM('activo', 'inactivo') DEFAULT 'activo',
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 4. TABLA: productos
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `productos` (
    `id_producto` INT AUTO_INCREMENT PRIMARY KEY,
    `id_categoria` INT NOT NULL,
    `nombre` VARCHAR(150) NOT NULL,
    `descripcion` TEXT NULL,
    `precio` DECIMAL(10, 2) NOT NULL CHECK (`precio` >= 0),
    `stock` INT NOT NULL DEFAULT 0 CHECK (`stock` >= 0),
    `imagen` VARCHAR(255) DEFAULT 'default.png',
    `estado` ENUM('activo', 'inactivo') DEFAULT 'activo',
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_productos_categorias` 
        FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) 
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_productos_categoria` ON `productos` (`id_categoria`);
CREATE INDEX `idx_productos_nombre` ON `productos` (`nombre`);

-- -----------------------------------------------------------------------------
-- 5. TABLA: pedidos
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pedidos` (
    `id_pedido` INT AUTO_INCREMENT PRIMARY KEY,
    `id_usuario` INT NOT NULL,
    `fecha_pedido` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `total` DECIMAL(10, 2) NOT NULL CHECK (`total` >= 0),
    `estado` ENUM('pendiente', 'pagado', 'enviado', 'entregado', 'cancelado') DEFAULT 'pendiente',
    `direccion_envio` VARCHAR(255) NOT NULL,
    CONSTRAINT `fk_pedidos_usuarios` 
        FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) 
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_pedidos_usuario` ON `pedidos` (`id_usuario`);
CREATE INDEX `idx_pedidos_estado` ON `pedidos` (`estado`);

-- -----------------------------------------------------------------------------
-- 6. TABLA: detalle_pedidos
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `detalle_pedidos` (
    `id_detalle` INT AUTO_INCREMENT PRIMARY KEY,
    `id_pedido` INT NOT NULL,
    `id_producto` INT NOT NULL,
    `cantidad` INT NOT NULL CHECK (`cantidad` > 0),
    `precio_unitario` DECIMAL(10, 2) NOT NULL CHECK (`precio_unitario` >= 0),
    `subtotal` DECIMAL(10, 2) NOT NULL CHECK (`subtotal` >= 0),
    CONSTRAINT `fk_detalle_pedidos` 
        FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_detalle_productos` 
        FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) 
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_detalle_pedido` ON `detalle_pedidos` (`id_pedido`);