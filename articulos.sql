-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2025 a las 07:28:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `portal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `nombre_articulo` varchar(255) NOT NULL,
  `codigo_isp` varchar(50) DEFAULT NULL,
  `codigo_barra` varchar(100) DEFAULT NULL,
  `concentracion` varchar(50) DEFAULT NULL,
  `forma_farmaceutica` varchar(100) DEFAULT NULL,
  `via_administracion` varchar(100) DEFAULT NULL,
  `unidad_medida` varchar(50) NOT NULL,
  `presentacion` varchar(255) DEFAULT NULL,
  `laboratorio` varchar(255) DEFAULT NULL,
  `tipo_articulo` varchar(50) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `usuario_creador_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `nombre_articulo`, `codigo_isp`, `codigo_barra`, `concentracion`, `forma_farmaceutica`, `via_administracion`, `unidad_medida`, `presentacion`, `laboratorio`, `tipo_articulo`, `stock_minimo`, `activo`, `fecha_creacion`, `usuario_creador_id`) VALUES
(1, 'Paracetamol', 'F-2145/22', '7800001001234', '500mg', 'Comprimido', 'Oral', 'Caja', 'Caja 20 comprimidos', 'Laboratorio Chile', 'Medicamento', 10, 1, '2025-06-14 01:21:51', 823);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
