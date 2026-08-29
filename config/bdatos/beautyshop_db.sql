-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2026 at 08:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beautyshop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `estado`, `fecha_creacion`) VALUES
(1, 'Cuidado Facial (Skincare)', 'Serums, cremas hidratantes, limpiadores y protectores solares', 'activo', '2026-08-28 22:35:53'),
(2, 'Maquillaje', 'Bases, labiales, pestañinas y paletas de sombras', 'activo', '2026-08-28 22:35:53'),
(3, 'Cuidado Capilar', 'Shampoos, acondicionadores, mascarillas y aceites para el cabello', 'activo', '2026-08-28 22:35:53'),
(4, 'Perfumería', 'Fragancias exclusivas, colonias y perfumes florales/cítricos', 'activo', '2026-08-28 22:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL CHECK (`cantidad` > 0),
  `precio_unitario` decimal(10,2) NOT NULL CHECK (`precio_unitario` >= 0),
  `subtotal` decimal(10,2) NOT NULL CHECK (`subtotal` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(6, 6, 6, 1, 145000.00, 145000.00),
(7, 6, 4, 1, 78000.00, 78000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_pedido` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL CHECK (`total` >= 0),
  `estado` enum('pendiente','pagado','enviado','entregado','cancelado') DEFAULT 'pendiente',
  `direccion_envio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `fecha_pedido`, `total`, `estado`, `direccion_envio`) VALUES
(6, 3, '2026-08-29 13:16:50', 223000.00, 'pendiente', 'Calle 16');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL CHECK (`precio` >= 0),
  `stock` int(11) NOT NULL DEFAULT 0 CHECK (`stock` >= 0),
  `imagen` varchar(255) DEFAULT 'default.png',
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_producto`, `id_categoria`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `estado`, `fecha_creacion`) VALUES
(1, 1, 'Serum Hidratante Ácido Hialurónico', 'Serum concentrado para hidratación profunda 30ml', 85000.00, 50, '243a45b1b8e5e471f0727d74b902df73.png', 'activo', '2026-08-28 22:35:53'),
(2, 1, 'Protector Solar Gel FPS 50+', 'Protección solar toque seco, rápida absorción 50g', 62000.00, 50, '928bc1a80351930c4439016c1b039159.png', 'activo', '2026-08-28 22:35:53'),
(3, 2, 'Labial Mate Larga Duración Rojo Velvet', 'Labial fluido con acabado aterciopelado intransferible', 35000.00, 50, 'ffb7b293f47fdc52d6304c7c73223218.png', 'activo', '2026-08-28 22:35:53'),
(4, 2, 'Base de Maquillaje Cobertura Total', 'Base líquida acabado natural 24h tono medio 30ml', 78000.00, 49, 'ee19c13c4072431fabf1c15e2abfd9ae.png', 'activo', '2026-08-28 22:35:53'),
(5, 3, 'Aceite de Argan Reparador Nocturno', 'Tratamiento restaurador para puntas maltratadas 100ml', 54000.00, 50, '15cdf9dfd3df422adc94107a15d8f164.png', 'activo', '2026-08-28 22:35:53'),
(6, 4, 'Eau de Parfum Floral Rose 100ml', 'Fragancia femenina notas de rosa, jazmín y vainilla', 145000.00, 49, '882f09a0c282730e8ef7131eda773c4d.png', 'activo', '2026-08-28 22:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`, `descripcion`, `fecha_creacion`) VALUES
(1, 'Administrador', 'Control total del sistema, catálogo, inventario y gestión de pedidos', '2026-08-28 22:35:53'),
(2, 'Cliente', 'Usuario final que puede explorar catálogo, armar carrito y realizar compras', '2026-08-28 22:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_rol`, `nombre`, `correo`, `password`, `telefono`, `direccion`, `estado`, `fecha_registro`) VALUES
(1, 1, 'Administrador BeautyShop', 'admin@beautyshop.com', '$2y$10$nSn2zcbxBxu7F34.Vg.N9eJmNPzJeZicjhT2M7MrOfG5Xa0zC968C', '3001234567', 'Calle Principal #10-20, Bogotá', 'activo', '2026-08-28 22:35:53'),
(2, 2, 'María López', 'cliente@gmail.com', '$2y$10$nSn2zcbxBxu7F34.Vg.N9eJmNPzJeZicjhT2M7MrOfG5Xa0zC968C', '3109876543', 'Carrera 15 #45-30, Medellín', 'activo', '2026-08-28 22:35:53'),
(3, 2, 'Washington Nieto', 'wnieto@gmail.com', '$2y$10$nSn2zcbxBxu7F34.Vg.N9eJmNPzJeZicjhT2M7MrOfG5Xa0zC968C', '3133163023', 'Calle 15', 'activo', '2026-08-29 12:24:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_detalle_productos` (`id_producto`),
  ADD KEY `idx_detalle_pedido` (`id_pedido`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `idx_pedidos_usuario` (`id_usuario`),
  ADD KEY `idx_pedidos_estado` (`estado`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `idx_productos_categoria` (`id_categoria`),
  ADD KEY `idx_productos_nombre` (`nombre`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_usuarios_roles` (`id_rol`),
  ADD KEY `idx_usuarios_correo` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `fk_detalle_pedidos` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON UPDATE CASCADE;

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
