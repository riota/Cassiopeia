-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-12-2017 a las 05:50:52
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `repositorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `detalle` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tamaño` double NOT NULL,
  `datos` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_modificacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `id_carpeta` int(11) NOT NULL,
  `autor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `facultad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `url` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id`, `nombre`, `detalle`, `tamaño`, `datos`, `fecha_creacion`, `fecha_modificacion`, `id_carpeta`, `autor`, `facultad`, `url`, `estado`) VALUES
(34, 'Investigación - Simulacion.docx', 'ARCHIVO', 800948, '', '11/12/2017', '', 25, '6-719-776', 'ING. DE SISTEMAS COMPUTACIONALES', 'ING. DE SISTEMAS COMPUTACIONALES/PROGRAMACION', 'PRIVADO'),
(35, 'manipulacion_de_hechos_en_clips.pdf', 'ARCHIVO', 484555, '', '11/12/2017', '', 28, '8-458-758', 'CIENCIAS Y TECNOLOGIA', 'CIENCIAS Y TECNOLOGIA/PARCIALES/PARCIAL 1', 'PUBLICO'),
(36, 'para hoy.docx', 'ARCHIVO', 217715, '', '11/12/2017', '', 28, '8-458-758', 'CIENCIAS Y TECNOLOGIA', 'CIENCIAS Y TECNOLOGIA/PARCIALES/PARCIAL 1', 'PRIVADO'),
(37, 'propiedades de la materia.docx', 'ARCHIVO', 151257, '', '11/12/2017', '', 28, '6-720-1284', 'CIENCIAS Y TECNOLOGIA', 'CIENCIAS Y TECNOLOGIA/PARCIALES/PARCIAL 1', 'PUBLICO'),
(38, 'Ejemplo', 'TEXTO', 0, 'Esto es un ejemplo                              ', '11/12/2017', '', 27, '6-720-1284', 'CIENCIAS Y TECNOLOGIA', 'CIENCIAS Y TECNOLOGIA/PARCIALES', 'PUBLICO'),
(39, 'EJEMPLO2', 'TEXTO', 0, 'PRIVADO                              ', '11/12/2017', '', 27, '6-720-1284', 'CIENCIAS Y TECNOLOGIA', 'CIENCIAS Y TECNOLOGIA/PARCIALES', 'PRIVADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carpetas`
--

CREATE TABLE `carpetas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `facultad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `id_padre` int(11) NOT NULL,
  `url` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `carpetas`
--

INSERT INTO `carpetas` (`id`, `nombre`, `facultad`, `id_padre`, `url`) VALUES
(1, 'RAIZ', '', 0, ''),
(2, 'ING. DE SISTEMAS COMPUTACIONALES', 'ING. DE SISTEMAS COMPUTACIONALES', 1, 'RAIZ/'),
(3, 'ING. CIVIL', 'ING. CIVIL', 1, 'RAIZ/'),
(4, 'ING. MECANICA', 'ING. MECANICA', 1, 'RAIZ/'),
(5, 'ING. ELECTRICA', 'ING. ELECTRICA', 1, 'RAIZ/'),
(6, 'ING. INDUSTRIAL', 'ING. INDUSTRIAL', 1, 'RAIZ/'),
(7, 'CIENCIAS Y TECNOLOGIA', 'CIENCIAS Y TECNOLOGIA', 1, 'RAIZ/'),
(25, 'PROGRAMACION', 'ING. DE SISTEMAS COMPUTACIONALES', 2, 'ING. DE SISTEMAS COMPUTACIONALES'),
(26, 'ARQUITECTURA', 'ING. DE SISTEMAS COMPUTACIONALES', 2, 'ING. DE SISTEMAS COMPUTACIONALES'),
(27, 'PARCIALES', 'CIENCIAS Y TECNOLOGIA', 7, 'CIENCIAS Y TECNOLOGIA'),
(28, 'PARCIAL 1', 'CIENCIAS Y TECNOLOGIA', 27, 'CIENCIAS Y TECNOLOGIA/PARCIALES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_archivos`
--

CREATE TABLE `tipos_archivos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipos_archivos`
--

INSERT INTO `tipos_archivos` (`id`, `tipo`, `size`) VALUES
(4, 'docx', 4194304),
(6, 'pdf', 2097152);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cedula` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `facultad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `rol` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `adm_folder` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `cedula`, `nombre`, `facultad`, `rol`, `estado`, `imagen`, `password`, `adm_folder`) VALUES
(27, '6-719-776', 'JORGE ORTIZ', 'ING. DE SISTEMAS COMPUTACIONALES', 'USER', 'ACTIVO', '6-719-776.jpg', '123', 'SI'),
(29, '6-720-1284', 'JENNIFER CAMPOS', 'CIENCIAS Y TECNOLOGIA', 'USER', 'ACTIVO', '6-720-1284.jpg', '123', 'NO'),
(26, '6-720-167', 'ROBERT GIBBS', 'ING. DE SISTEMAS COMPUTACIONALES', 'ADMIN', 'ACTIVO', '6-720-167.jpg', '123', 'SI'),
(28, '8-458-758', 'Luiyiana Pérez', 'CIENCIAS Y TECNOLOGIA', 'ADMIN', 'ACTIVO', 'profile.jpg', '123', 'SI'),
(1, 'SUPER', 'JOE TORRES', '', 'SUPER', 'ACTIVO', 'SUPER.png', '123', 'SI');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `tipos_archivos`
--
ALTER TABLE `tipos_archivos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT de la tabla `tipos_archivos`
--
ALTER TABLE `tipos_archivos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
