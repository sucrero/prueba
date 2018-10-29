-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 29-10-2018 a las 02:24:38
-- Versión del servidor: 8.0.13
-- Versión de PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba_bdd`
--
CREATE DATABASE IF NOT EXISTS `prueba_bdd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `prueba_bdd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso`
--

CREATE TABLE `proceso` (
  `idproces` int(11) NOT NULL,
  `numproces` varchar(8) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descrip` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecalta` date NOT NULL,
  `sede` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `presupuesto` float(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proceso`
--

INSERT INTO `proceso` (`idproces`, `numproces`, `descrip`, `fecalta`, `sede`, `presupuesto`) VALUES
(1, '22222223', 'descripción', '0000-00-00', 'méxico', 22.00),
(2, '11111111', 'descripción', '0000-00-00', 'méxico', 22222.22),
(3, '11111119', 'descripción9', '0000-00-00', 'méxico', 22.22),
(4, '23222222', 'descripción', '2018-10-28', 'méxico', 22222.22),
(5, '11111118', 'descripción', '0000-00-00', 'méxico', 22.22),
(6, 'weqdfqwe', 'dwwqdqw qwdwqdwq', '2018-10-04', 'bogotá', 234124.34),
(7, 'gregerge', 'greggre gregr', '2018-10-27', 'bogotá', 3454354432.00),
(8, 'gregrege', 'gerg ergregeg', '2018-10-10', 'méxico', 2353533.50),
(9, '22222228', 'gregrregre ergrrgereg', '2018-10-11', 'méxico', 3453435.50),
(10, '12345678', 'decsripcón modificada', '2018-10-27', 'bogotá', 2313.45),
(11, '12345677', 'dqwedfqwe qewfefewfewewf', '2018-10-28', 'bogotá', 1200000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resetpass`
--

CREATE TABLE `resetpass` (
  `idresetpass` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `nomusuario` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tokein` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechain` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombreusu` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apeusu` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `loginusu` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `claveusu` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=activo, 0=inactivo',
  `fechaalta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombreusu`, `apeusu`, `loginusu`, `claveusu`, `status`, `fechaalta`) VALUES
(1, 'oswaldo', 'franco', 'franco.oswaldo@gmail.com', '$2a$08$y.rq7cbOyXkjLAmYYuG20OnO0iMwVBPCzZ4FK6zaL4m3fnEMm/uXu', 1, '2018-10-05 10:30:12'),
(2, 'juán', 'peñalver suaréz', 'juan@correo.com', '$2a$08$9PF8QGIQmFrmZxGSbpwkcetAVLucXfriMHt3ZXVYut1EuCddOt0LW', 1, '2018-10-27 06:44:17'),
(3, 'andres', 'peña', 'andres@correo.com', '$2a$08$UAYFx/vzYYjB6t2dGqbssumQMA1u3MLDPXNJWBNC3x7dUMOIacXR.', 1, '2018-10-27 06:45:04'),
(4, 'gfergrr', 'ergegrr', 'rgregr@wefwew.com', '$2a$08$mOEhyp9d3sGdBo.TkKw5FeIxcxlYhRk4cRkOwj1Qga2KRVVnJ3n7W', 1, '2018-10-27 06:45:57'),
(5, 'luis carlos', 'perez', 'correo@gmail.com', '$2a$08$370JeCdJ1J/Ov6vh7y8aFubgpuMVQGGM1/rP1ib79yPblKAq56B8y', 1, '2018-10-28 23:32:21'),
(6, 'probando', 'peña', 'gfergregr@ergrwe.com', '$2a$08$dI5K2nFrrReG1T.xFTgUmeEUMa1U/rNVy7WwFQb9MprB9D1/PBrbW', 1, '2018-10-28 23:34:11'),
(7, 'eewfwefw', 'efewwefew', 'wefefwefew@wgfeew.com', '$2a$08$Bwr8MFMO35DbJ.1/HU3NCOosu8NXQTXDJkVlR/bG07rVEbdZxZc0y', 1, '2018-10-28 23:34:27'),
(8, 'admin', 'prueba', 'admin@admin.com', '$2a$08$zJHH/9SD.3Lj1EzE.OowleWUY9hWZY.10OqUNULQx9Z.HQPNUxS7u', 1, '2018-10-29 00:53:37'),
(9, 'pruebas', 'prueba2', 'prueba@prueba.com', '$2a$08$M18fjz0Af2/u/9rZ96u0leEA/EssNyvNcJSjUcOm/4a0Lkh3fFivq', 0, '2018-10-29 01:10:40');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `proceso`
--
ALTER TABLE `proceso`
  ADD PRIMARY KEY (`idproces`);

--
-- Indices de la tabla `resetpass`
--
ALTER TABLE `resetpass`
  ADD PRIMARY KEY (`idresetpass`),
  ADD KEY `fk_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `proceso`
--
ALTER TABLE `proceso`
  MODIFY `idproces` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `resetpass`
--
ALTER TABLE `resetpass`
  MODIFY `idresetpass` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `resetpass`
--
ALTER TABLE `resetpass`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
