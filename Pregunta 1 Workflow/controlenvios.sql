-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2024 a las 21:23:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `controlenvios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despachodetalles`
--

CREATE TABLE `despachodetalles` (
  `id_detalle` int(11) NOT NULL,
  `id_despacho` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `despachodetalles`
--

INSERT INTO `despachodetalles` (`id_detalle`, `id_despacho`, `id_producto`, `cantidad`) VALUES
(1, 1, 1, 10),
(2, 1, 2, 5),
(3, 2, 2, 20),
(4, 2, 3, 15),
(5, 1, 1, 2),
(6, 1, 3, 2),
(7, 2, 1, 2),
(8, 2, 3, 2),
(9, 3, 1, 2),
(10, 3, 3, 2),
(11, 1, 1, 2),
(12, 1, 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despachos`
--

CREATE TABLE `despachos` (
  `id_despacho` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `estado` enum('Pendiente','Completado','Cerrado') NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `despachos`
--

INSERT INTO `despachos` (`id_despacho`, `descripcion`, `estado`) VALUES
(1, 'Despacho A', 'Pendiente'),
(2, 'Despacho B', 'Pendiente'),
(3, 'Despacho C', 'Pendiente'),
(4, 'Despacho D', 'Pendiente'),
(5, 'Despacho E', 'Pendiente'),
(6, 'Despacho F', 'Pendiente'),
(7, 'Despacho G', 'Pendiente'),
(8, 'Despacho H', 'Pendiente'),
(9, 'Despacho I', 'Pendiente'),
(10, 'Despacho J', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flujoprocesos`
--

CREATE TABLE `flujoprocesos` (
  `flujo` varchar(10) NOT NULL,
  `proceso` varchar(10) NOT NULL,
  `siguiente` varchar(10) DEFAULT NULL,
  `rol` varchar(50) NOT NULL,
  `pantalla` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `flujoprocesos`
--

INSERT INTO `flujoprocesos` (`flujo`, `proceso`, `siguiente`, `rol`, `pantalla`) VALUES
('F1', 'P1', 'P2', 'Operador', 'seleccionarProducto'),
('F1', 'P2', 'P3', 'Operador', 'asignarTransporte'),
('F1', 'P3', 'P4', 'Transportista', 'realizarDespacho'),
('F1', 'P4', 'P5', 'Transportista', 'confirmarEntrega'),
('F1', 'P5', NULL, 'Supervisor', 'cerrarDespacho'),
('F2', 'P1', 'P2', 'Supervisor', 'registrarRecepcion'),
('F2', 'P2', 'P3', 'Operador', 'verificarInventario'),
('F2', 'P3', NULL, 'Administrador', 'finalizarRecepcion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flujoseguimiento`
--

CREATE TABLE `flujoseguimiento` (
  `nro_tramite` int(11) NOT NULL,
  `flujo` varchar(10) NOT NULL,
  `proceso` varchar(10) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `flujoseguimiento`
--

INSERT INTO `flujoseguimiento` (`nro_tramite`, `flujo`, `proceso`, `usuario`, `fecha_inicio`, `fecha_fin`) VALUES
(12, 'F1', 'P1', 1, '2024-12-02 21:52:26', NULL),
(13, 'F1', 'P1', 1, '2024-12-02 23:30:36', NULL),
(14, 'F1', 'P1', 1, '2024-12-02 23:30:52', NULL),
(15, 'F1', 'P1', 1, '2024-12-02 23:31:56', NULL),
(16, 'F1', 'P2', 1, '2024-12-02 23:36:09', NULL),
(17, 'F1', 'P1', 1, '2024-12-03 00:08:32', NULL),
(18, 'F1', 'P2', 1, '2024-12-03 00:08:39', NULL),
(19, 'F1', 'P2', 1, '2024-12-03 00:11:13', NULL),
(20, 'F1', 'P1', 1, '2024-12-03 00:15:53', NULL),
(21, 'F1', 'P2', 1, '2024-12-03 00:15:58', NULL),
(22, 'F1', 'P2', 1, '2024-12-03 00:46:35', NULL),
(23, 'F1', 'P2', 1, '2024-12-03 00:52:37', NULL),
(24, 'F1', 'P2', 1, '2024-12-03 01:15:44', NULL),
(25, 'F1', 'P2', 1, '2024-12-03 01:16:12', NULL),
(26, 'F1', 'P2', 1, '2024-12-03 01:34:47', NULL),
(27, 'F1', 'P2', 1, '2024-12-03 01:58:25', NULL),
(28, 'F1', 'P2', 1, '2024-12-03 23:26:20', NULL),
(29, 'F1', 'P2', 1, '2024-12-04 11:40:36', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `descripcion`, `cantidad`) VALUES
(1, 'Producto A', 'Descripción del producto A', 102),
(2, 'Producto B', 'Descripción del producto B', 52),
(3, 'Producto C', 'Descripción del producto C', 201),
(4, 'Producto D', 'Descripción del producto D', 150),
(5, 'Producto E', 'Descripción del producto E', 80),
(6, 'Producto F', 'Descripción del producto F', 120),
(7, 'Producto G', 'Descripción del producto G', 60),
(8, 'Producto H', 'Descripción del producto H', 90),
(9, 'Producto I', 'Descripción del producto I', 250),
(10, 'Producto J', 'Descripción del producto J', 300),
(11, 'Producto K', 'Descripción del producto J', 100),
(12, 'Producto L', 'Descripción del producto L', 50),
(13, 'Juguetes', 'Muñecas', 10),
(14, 'Cartas', 'Coleccion', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepciondetalles`
--

CREATE TABLE `recepciondetalles` (
  `id_detalle` int(11) NOT NULL,
  `id_recepcion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recepciondetalles`
--

INSERT INTO `recepciondetalles` (`id_detalle`, `id_recepcion`, `id_producto`, `cantidad`) VALUES
(1, 1, 1, 20),
(2, 1, 2, 15),
(3, 2, 3, 50),
(4, 2, 4, 30),
(5, 3, 5, 40),
(6, 3, 6, 60),
(7, 4, 7, 25),
(8, 4, 8, 50),
(9, 5, 9, 100),
(10, 5, 10, 150),
(11, 6, 1, 0),
(12, 6, 2, 0),
(13, 6, 3, 0),
(14, 7, 1, 1),
(15, 7, 2, 1),
(16, 7, 3, 1),
(17, 8, 1, 1),
(18, 8, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepciones`
--

CREATE TABLE `recepciones` (
  `id_recepcion` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recepciones`
--

INSERT INTO `recepciones` (`id_recepcion`, `fecha`, `observaciones`) VALUES
(1, '2024-12-01 10:00:00', 'Primera recepción, productos en buen estado.'),
(2, '2024-12-02 15:30:00', 'Recepción parcial, faltantes reportados.'),
(3, '2024-12-03 09:45:00', 'Recepción de productos adicionales, sin observaciones.'),
(4, '2024-12-03 14:20:00', 'Productos entregados en empaques correctos.'),
(5, '2024-12-04 08:10:00', 'Recepción final, todo conforme.'),
(6, '2024-12-03 12:58:44', 'Todo bien'),
(7, '2024-12-03 13:29:13', 'Ok'),
(8, '2024-12-03 16:54:21', 'Ok'),
(9, '2024-12-04 11:42:18', 'Ok');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transporte`
--

CREATE TABLE `transporte` (
  `id_transporte` int(11) NOT NULL,
  `tipo_transporte` varchar(50) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1,
  `nombre_transporte` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transporte`
--

INSERT INTO `transporte` (`id_transporte`, `tipo_transporte`, `placa`, `capacidad`, `disponible`, `nombre_transporte`) VALUES
(4, 'Camión', 'ABC-123', 1000, 1, 'Camión Grande'),
(5, 'Avión', 'AIR-567', 20000, 1, 'Avión Carguero'),
(6, 'Barco', 'SEA-890', 50000, 1, 'Barco Mercante'),
(7, 'Camioneta', 'DEF-456', 500, 1, 'Camioneta Pequeña'),
(8, 'Moto', 'GHI-789', 50, 1, 'Moto Rápida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rol` enum('Admin','Operador','Transportista') NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `rol`, `contraseña`) VALUES
(1, 'Admin General', 'admin@empresa.com', 'Admin', '0192023a7bbd73250516f069df18b500'),
(2, 'Operador 1', 'operador1@empresa.com', 'Operador', '07d430ce23ec43ba6a631dde9b17fc2d'),
(3, 'Transportista 1', 'transportista1@empresa.com', 'Transportista', '9ad292f09f938676969a613de6c6853c');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `despachodetalles`
--
ALTER TABLE `despachodetalles`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_despacho` (`id_despacho`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `despachos`
--
ALTER TABLE `despachos`
  ADD PRIMARY KEY (`id_despacho`);

--
-- Indices de la tabla `flujoprocesos`
--
ALTER TABLE `flujoprocesos`
  ADD PRIMARY KEY (`flujo`,`proceso`);

--
-- Indices de la tabla `flujoseguimiento`
--
ALTER TABLE `flujoseguimiento`
  ADD PRIMARY KEY (`nro_tramite`),
  ADD KEY `flujo` (`flujo`,`proceso`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `recepciondetalles`
--
ALTER TABLE `recepciondetalles`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_recepcion` (`id_recepcion`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `recepciones`
--
ALTER TABLE `recepciones`
  ADD PRIMARY KEY (`id_recepcion`);

--
-- Indices de la tabla `transporte`
--
ALTER TABLE `transporte`
  ADD PRIMARY KEY (`id_transporte`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `despachodetalles`
--
ALTER TABLE `despachodetalles`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `despachos`
--
ALTER TABLE `despachos`
  MODIFY `id_despacho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `flujoseguimiento`
--
ALTER TABLE `flujoseguimiento`
  MODIFY `nro_tramite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `recepciondetalles`
--
ALTER TABLE `recepciondetalles`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `recepciones`
--
ALTER TABLE `recepciones`
  MODIFY `id_recepcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `transporte`
--
ALTER TABLE `transporte`
  MODIFY `id_transporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `despachodetalles`
--
ALTER TABLE `despachodetalles`
  ADD CONSTRAINT `despachodetalles_ibfk_1` FOREIGN KEY (`id_despacho`) REFERENCES `despachos` (`id_despacho`),
  ADD CONSTRAINT `despachodetalles_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `flujoseguimiento`
--
ALTER TABLE `flujoseguimiento`
  ADD CONSTRAINT `flujoseguimiento_ibfk_1` FOREIGN KEY (`flujo`,`proceso`) REFERENCES `flujoprocesos` (`flujo`, `proceso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flujoseguimiento_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recepciondetalles`
--
ALTER TABLE `recepciondetalles`
  ADD CONSTRAINT `recepciondetalles_ibfk_1` FOREIGN KEY (`id_recepcion`) REFERENCES `recepciones` (`id_recepcion`),
  ADD CONSTRAINT `recepciondetalles_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
