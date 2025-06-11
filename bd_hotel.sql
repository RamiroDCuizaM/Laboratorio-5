-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2025 a las 22:06:46
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
-- Base de datos: `bd_hotel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotografiashabitaciones`
--

CREATE TABLE `fotografiashabitaciones` (
  `id` int(11) NOT NULL,
  `habitacion_id` int(11) DEFAULT NULL,
  `fotografia` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotografiashabitaciones`
--

INSERT INTO `fotografiashabitaciones` (`id`, `habitacion_id`, `fotografia`, `orden`) VALUES
(1, 1, 'hab_101_frontal.jpg', 1),
(2, 1, 'hab_101_cama.jpg', 2),
(3, 2, 'hab_102_frontal.jpg', 1),
(4, 2, 'hab_102_cama.jpg', 2),
(5, 5, 'hab_202_frontal.jpg', 1),
(6, 5, 'hab_202_cama.jpg', 2),
(7, 7, 'hab_301_sala.jpg', 1),
(8, 7, 'hab_301_cama.jpg', 2),
(9, 7, 'hab_301_comedor.jpg', 3),
(20, 1, 'hab_101_frontal.jpg', 1),
(21, 1, 'hab_101_cama.jpg', 2),
(22, 2, 'hab_102_frontal.jpg', 1),
(23, 2, 'hab_102_cama.jpg', 2),
(24, 3, 'hab_103_frontal.jpg', 1),
(25, 3, 'hab_103_cama.jpg', 2),
(26, 4, 'hab_201_frontal.jpg', 1),
(27, 4, 'hab_201_cama.jpg', 2),
(28, 5, 'hab_202_frontal.jpg', 1),
(29, 5, 'hab_202_cama.jpg', 2),
(30, 6, 'hab_203_frontal.jpg', 1),
(31, 6, 'hab_203_cama.jpg', 2),
(33, 7, 'hab_301_cama.jpg', 2),
(34, 8, 'hab_302_frontal.jpg', 1),
(35, 8, 'hab_302_cama.jpg', 2),
(36, 9, 'hab_303_frontal.jpg', 1),
(37, 9, 'hab_303_cama.jpg', 2),
(38, 10, 'hab_304_frontal.jpg', 1),
(39, 10, 'hab_304_cama.jpg', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `id` int(11) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `piso` int(11) DEFAULT NULL,
  `tipohabitacion_id` int(11) DEFAULT NULL,
  `estado` enum('disponible','ocupada','mantenimiento') DEFAULT 'disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`id`, `numero`, `piso`, `tipohabitacion_id`, `estado`) VALUES
(1, '101', 1, 1, 'disponible'),
(2, '102', 1, 2, 'disponible'),
(3, '103', 1, 2, 'disponible'),
(4, '201', 2, 1, 'disponible'),
(5, '202', 2, 3, 'disponible'),
(6, '203', 2, 2, 'disponible'),
(7, '301', 3, 4, 'disponible'),
(8, '302', 3, 3, 'disponible'),
(9, '303', 3, 2, 'disponible'),
(10, '304', 3, 1, 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Tarjeta de Crédito', 'Pago con tarjeta de crédito'),
(2, 'Tarjeta de Débito', 'Pago con tarjeta de débito'),
(3, 'Efectivo', 'Pago en efectivo'),
(4, 'Transferencia Bancaria', 'Pago por transferencia bancaria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `habitacion_id` int(11) DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` enum('pendiente','confirmada','cancelada') DEFAULT 'pendiente',
  `metodo_pago_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipohabitacion`
--

CREATE TABLE `tipohabitacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `superficie` decimal(5,2) DEFAULT NULL,
  `nro_camas` int(11) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipohabitacion`
--

INSERT INTO `tipohabitacion` (`id`, `nombre`, `superficie`, `nro_camas`, `precio`) VALUES
(1, 'Simple', 20.50, 1, 0.00),
(2, 'Doble', 30.00, 2, 0.00),
(3, 'Suite', 45.00, 2, 0.00),
(4, 'Familiar', 60.00, 4, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') NOT NULL,
  `estado` enum('activo','suspendido') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`, `estado`) VALUES
(1, 'Ramiro', 'ramirodavidcuizamurana@gmail.com', '123456', 'admin', 'activo'),
(2, 'carlos', 'carlitos@gmail.com', '234567', 'usuario', 'activo'),
(3, 'Juan Jose ', 'juanjo@gmail.com', '345678', 'admin', 'suspendido'),
(4, 'Jhonatan', 'stick@gmail.com', '456789', 'admin', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `fotografiashabitaciones`
--
ALTER TABLE `fotografiashabitaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habitacion_id` (`habitacion_id`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipohabitacion_id` (`tipohabitacion_id`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `habitacion_id` (`habitacion_id`),
  ADD KEY `metodo_pago_id` (`metodo_pago_id`);

--
-- Indices de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fotografiashabitaciones`
--
ALTER TABLE `fotografiashabitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fotografiashabitaciones`
--
ALTER TABLE `fotografiashabitaciones`
  ADD CONSTRAINT `fotografiashabitaciones_ibfk_1` FOREIGN KEY (`habitacion_id`) REFERENCES `habitacion` (`id`);

--
-- Filtros para la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `habitacion_ibfk_1` FOREIGN KEY (`tipohabitacion_id`) REFERENCES `tipohabitacion` (`id`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`habitacion_id`) REFERENCES `habitacion` (`id`),
  ADD CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodos_pago` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
