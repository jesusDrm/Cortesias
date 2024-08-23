-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-08-2024 a las 20:36:52
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pasaportes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `ID` int(11) NOT NULL,
  `NombreID` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `NumeroCortesias` int(100) NOT NULL,
  `Clave de rango inicial` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Clave de rango final` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombres`
--

CREATE TABLE `nombres` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Clave` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `nombres`
--

INSERT INTO `nombres` (`ID`, `Nombre`, `Clave`) VALUES
(1, 'Camacho Bianca Stella', 'B37'),
(2, 'Camacho Carolina del Carmen', 'M55'),
(3, 'Camacho Wardle Gregory Atila', 'T80'),
(4, 'Camacho Wardle Frank Carlos Arthur', 'Z30'),
(5, 'Camacho Dayami Naytze', 'D37'),
(6, 'Camacho Wardle Honorine Juliette', 'H37'),
(7, 'Camacho Erica Virginia', 'K60');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posicion`
--

CREATE TABLE `posicion` (
  `ejey_qr` int(8) NOT NULL,
  `ejex_qr` int(8) NOT NULL,
  `ejex_texto` int(8) NOT NULL,
  `ejey_texto` int(8) NOT NULL,
  `area_qr` int(8) NOT NULL,
  `tam_texto` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `posicion`
--

INSERT INTO `posicion` (`ejey_qr`, `ejex_qr`, `ejex_texto`, `ejey_texto`, `area_qr`, `tam_texto`) VALUES
(595, 82, 130, 875, 260, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `id` int(11) NOT NULL,
  `Cortesias` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`id`, `Cortesias`) VALUES
(1, 'pswas123'),
(2, 'Pruebemos');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_historial_nombres_idx` (`NombreID`);

--
-- Indices de la tabla `nombres`
--
ALTER TABLE `nombres`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nombres`
--
ALTER TABLE `nombres`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `fk_historial_nombres` FOREIGN KEY (`NombreID`) REFERENCES `nombres` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
