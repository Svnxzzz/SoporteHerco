-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2025 a las 20:48:59
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
-- Base de datos: `soporte_herco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `articulo` varchar(255) NOT NULL,
  `sucursal` varchar(100) NOT NULL,
  `fallo` varchar(255) NOT NULL,
  `entregado_por` varchar(100) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `estado` enum('pendiente','en proceso','terminado','entregado','descartado') NOT NULL,
  `fecha_entregado` datetime DEFAULT NULL,
  `fecha_descartado` datetime DEFAULT NULL,
  `nota` text DEFAULT NULL,
  `recibido_por` varchar(100) DEFAULT NULL,
  `n_serie` varchar(255) DEFAULT NULL,
  `accesorio` varchar(255) DEFAULT NULL,
  `condicion` enum('Nuevo','En uso') NOT NULL DEFAULT 'Nuevo',
  `tecnico_reparo` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `articulo`, `sucursal`, `fallo`, `entregado_por`, `fecha_hora`, `estado`, `fecha_entregado`, `fecha_descartado`, `nota`, `recibido_por`, `n_serie`, `accesorio`, `condicion`, `tecnico_reparo`, `activo`) VALUES
(176, 'CPU DELL', 'CD Ferretero', 'No tiene sesion en VM', 'Jimmy de Ingresos', '2025-05-21 10:47:00', 'en proceso', NULL, NULL, 'Se inicio revision', 'Juan Cruz', 'INFO 1063', 'Fuente de poder y mouse', 'En uso', 'Juan Cruz', 1),
(177, 'Monitor HP', 'CD Ferretero', 'Pantalla quemada', 'Jimmy de Ingresos', '2025-05-21 10:55:00', 'descartado', NULL, '2025-05-22 11:08:16', 'No hay repuestos', 'Juan Cruz', 'INFO 096', 'Fuente de poder y cable VGA', 'En uso', 'Juan Cruz', 1),
(179, 'Impresora Zebra', 'Herco San Lorenzo', 'Falla al imprimir', 'Keren Lopez', '2025-05-21 14:14:00', 'pendiente', NULL, NULL, NULL, 'Juan Cruz', 'INFO 919', 'Fuente de poder y cable usb A-B', 'En uso', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_estados`
--

CREATE TABLE `historial_estados` (
  `id` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `estado_anterior` varchar(50) NOT NULL,
  `estado_nuevo` varchar(50) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_estados`
--

INSERT INTO `historial_estados` (`id`, `id_articulo`, `estado_anterior`, `estado_nuevo`, `usuario`, `fecha_hora`) VALUES
(102, 177, 'pendiente', 'descartado', '', '2025-05-22 11:07:58'),
(103, 177, 'descartado', 'en proceso', '', '2025-05-22 11:08:03'),
(104, 177, 'en proceso', 'descartado', 'No hay repuestos', '2025-05-22 11:08:16'),
(105, 176, 'pendiente', 'en proceso', '', '2025-05-22 11:08:38'),
(106, 176, 'en proceso', 'terminado', 'Se inicio revision', '2025-05-22 11:08:52'),
(107, 176, 'terminado', 'en proceso', 'Se inicio revision', '2025-05-22 11:08:54'),
(115, 176, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:13:23'),
(116, 176, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:13:28'),
(117, 176, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:13:29'),
(118, 176, 'activo', 'inactivo', 'Juan Cruz | Nota: kvgm', '2025-05-22 12:13:38'),
(119, 176, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:16:05'),
(120, 176, 'activo', 'inactivo', 'Juan Cruz | Nota: mñl', '2025-05-22 12:16:11'),
(121, 177, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:16:22'),
(122, 176, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:19:44'),
(123, 176, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:21:06'),
(124, 177, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:21:13'),
(125, 176, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:22:06'),
(126, 179, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:22:34'),
(127, 176, 'inactivo', 'activo', 'Juan Cruz', '2025-05-22 12:23:49'),
(128, 179, 'inactivo', 'activo', 'Juan Cruz', '2025-05-22 12:23:54'),
(129, 177, 'inactivo', 'activo', 'Juan Cruz', '2025-05-22 12:23:56'),
(130, 179, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:23:58'),
(131, 179, 'inactivo', 'activo', 'Juan Cruz', '2025-05-22 12:24:30'),
(132, 176, 'en proceso', 'terminado', 'Se inicio revision', '2025-05-22 12:25:20'),
(133, 176, 'activo', 'inactivo', 'Juan Cruz | Nota: ESTA PESIMO', '2025-05-22 12:25:46'),
(134, 176, 'inactivo', 'activo', 'Juan Cruz', '2025-05-22 12:26:08'),
(135, 177, 'activo', 'inactivo', 'Juan Cruz', '2025-05-22 12:29:06'),
(136, 177, 'inactivo', 'activo', 'Juan Cruz', '2025-05-22 12:36:45'),
(137, 176, 'terminado', 'en proceso', 'Se inicio revision', '2025-05-22 12:38:28');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_estados`
--
ALTER TABLE `historial_estados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_articulo` (`id_articulo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT de la tabla `historial_estados`
--
ALTER TABLE `historial_estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_estados`
--
ALTER TABLE `historial_estados`
  ADD CONSTRAINT `historial_estados_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `articulos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
