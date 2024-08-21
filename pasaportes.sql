-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 21-08-2024 a las 18:39:46
-- Versión del servidor: 5.7.15-log
-- Versión de PHP: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `Nombre y codigo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Rango de folios` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombres`
--

CREATE TABLE `nombres` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Clave` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indices de la tabla `nombres`
--
ALTER TABLE `nombres`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
