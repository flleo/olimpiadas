-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 09-10-2017 a las 21:11:54
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdOlimpiadas`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `pCantidadMedallas` (IN `pais` VARCHAR(30), OUT `oro` INT, OUT `plata` INT, OUT `bronce` INT)  BEGIN
SELECT COUNT(*) INTO oro FROM medallas m INNER JOIN deportistas d ON m.codDeportista=d.codDeportista 
WHERE  d.paisDeportista=(SELECT codPais FROM paises WHERE nombrePais=pais) AND puestoDeportista='1';
SELECT COUNT(*) INTO plata FROM medallas m INNER JOIN deportistas d ON m.codDeportista=d.codDeportista 
WHERE  d.paisDeportista=(SELECT codPais FROM paises WHERE nombrePais=pais) AND puestoDeportista='2';
SELECT COUNT(*) INTO bronce FROM medallas m INNER JOIN deportistas d ON m.codDeportista=d.codDeportista 
WHERE  d.paisDeportista=(SELECT codPais FROM paises WHERE nombrePais=pais) AND puestoDeportista='3';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pInserteMedalla` (IN `dni` VARCHAR(12), IN `codPrueba` CHAR(5), IN `fecha` DATE, IN `puesto` CHAR(1))  BEGIN
	
    INSERT INTO medallas (codDeportista, codPrueba, fechaMedalla, puestoDeportista ) 
		VALUES ((SELECT codDeportista  FROM deportistas WHERE dniDeportista = dni),codPrueba,fecha,puesto) ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pListaDeportistas` (IN `pais` VARCHAR(30))  BEGIN
SELECT nombreDeportista FROM deportistas WHERE paisDeportista=(SELECT codPais FROM paises WHERE nombrePais=pais);
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fDeportistaPais` (`pais` VARCHAR(30)) RETURNS INT(11) BEGIN
RETURN (SELECT COUNT(*) from deportistas where paisDeportista=(SELECT codPais FROM paises WHERE nombrePais=pais));
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deportistas`
--

CREATE TABLE `deportistas` (
  `codDeportista` int(11) NOT NULL,
  `nombreDeportista` varchar(60) DEFAULT NULL,
  `dniDeportista` varchar(12) DEFAULT NULL,
  `paisDeportista` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `deportistas`
--

INSERT INTO `deportistas` (`codDeportista`, `nombreDeportista`, `dniDeportista`, `paisDeportista`) VALUES
(63, 'Marcelo', '66.326.236-d', 'BULG'),
(64, 'Rommel', '98.326.236-d', 'RUMA'),
(65, 'Mario', '99.326.236-d', 'RODE'),
(66, 'carlos', '45.555.874-G', 'BULG'),
(67, 'kolino', '43.791.853-z', 'RODE');

--
-- Disparadores `deportistas`
--
DELIMITER $$
CREATE TRIGGER `trEliminaDeportista` BEFORE DELETE ON `deportistas` FOR EACH ROW BEGIN
	
	INSERT INTO deportistasBorrados(codDeportista,dniDeportista,nombreDeportista,paisDeportista) VALUES 				                      (OLD.codDeportista,OLD.dniDeportista,OLD.nombreDeportista,OLD.paisDeportista);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deportistasBorrados`
--

CREATE TABLE `deportistasBorrados` (
  `codDeportista` int(11) DEFAULT NULL,
  `nombreDeportista` varchar(60) DEFAULT NULL,
  `dniDeportista` varchar(12) DEFAULT NULL,
  `paisDeportista` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `deportistasBorrados`
--

INSERT INTO `deportistasBorrados` (`codDeportista`, `nombreDeportista`, `dniDeportista`, `paisDeportista`) VALUES
(1, 'Romero', '78.326.236-d', 'espa'),
(2, 'Marcelo', '66.326.236-d', 'ESPA'),
(3, 'Rommel', '98.326.236-d', 'RUMA'),
(4, 'Mario', '99.326.236-d', 'RODE'),
(5, 'noro', '45.256.654-l', 'espa'),
(13, 'kiko', '78.875.548-z', 'bulg'),
(20, 'Romero', '78.326.236-d', 'ESPA'),
(21, 'Marcelo', '66.326.236-d', 'BULG'),
(22, 'Rommel', '98.326.236-d', 'RUMA'),
(23, 'Mario', '99.326.236-d', 'RODE'),
(26, 'Rommel', '98.326.236-d', 'RUMA'),
(24, 'Romero', '78.326.236-d', 'ESPA'),
(27, 'Mario', '99.326.236-d', 'BULG'),
(28, 'Federico', '32.323.232-r', 'BULG'),
(35, 'Marcelona', '66.326.236-w', 'BULG'),
(36, 'Raquiel', '45.258.258-l', 'BULG'),
(30, 'Polonononnn', '78.258.369-l', 'BULG'),
(38, 'Polo', '99.258.369-l', 'BULG'),
(37, 'Danilo', '23.233.233-r', 'BULG'),
(39, 'Daniel', '43.258.258-p', 'ESPA'),
(40, 'Cardadgo', '99.258.365-c', 'ESPA'),
(33, 'Mario', '78.258.258-k', 'RODE'),
(31, 'Carlos', '45.258.365-c', 'RUMA'),
(25, 'Marcelono', '66.326.236-d', 'ESPA'),
(26, 'lolo', '43.258.258-o', 'RUMA'),
(27, 'LOLOn', '78.258.258-k', 'BULG'),
(28, 'coco', '43.258.258-o', 'BULG'),
(29, 'lolo', '78.258.258-k', 'ESPA'),
(30, 'huhu', '43.258.258-o', 'BULG'),
(31, 'yuiy', '43.258.258-o', 'BULG'),
(32, 'lolo', '43.258.258-o', 'BULG'),
(34, 'mano', '78.258.258-k', 'RODE'),
(33, 'lolo', '43.258.258-o', 'BULG'),
(36, 'hugo', '78.258.258-k', 'BULG'),
(35, 'kolo', '43.258.258-o', 'BULG'),
(37, 'bolo', '43.258.258-o', 'ESPA'),
(38, 'ghj', '43.258.258-o', 'ESPA'),
(43, 'null', '43.791.853-z', 'BULG'),
(42, 'null', NULL, 'BULG'),
(44, 'null', '43.791.853-z', 'BULG'),
(39, 'nojoko', '43.258.258-o', 'BULG'),
(40, 'Tuy', '78.258.258-k', 'BULG'),
(41, 'ñol', '99.999.999-a', 'BULG'),
(46, 'raquel', '78.854.854-k', 'ESPA'),
(45, 'federico', '43.791.853-z', 'BULG'),
(47, 'Raquel', '78.854.854-k', 'ESPA'),
(48, 'jkl', '43.791.853-z', 'BULG'),
(49, 'marco', '43.791.853-z', 'BULG'),
(50, 'Titititititi', '78.854.854-k', 'ESPA'),
(61, 'carlos', '45.555.874-G', 'BULG'),
(60, 'Monica', '43.791.853-z', 'RODE'),
(58, 'Pipion', '98.876.043-d', 'ESPA'),
(62, 'Romero', '78.326.236-d', 'ESPA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medallas`
--

CREATE TABLE `medallas` (
  `codDeportista` int(11) NOT NULL,
  `codPrueba` char(5) NOT NULL,
  `fechaMedalla` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `puestoDeportista` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `codPais` char(4) NOT NULL,
  `nombrePais` varchar(30) DEFAULT 'ESPAÑA'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`codPais`, `nombrePais`) VALUES
('BULG', 'BULGARIA'),
('ESPA', 'ESPAÑA'),
('RODE', 'RODESIA'),
('RUMA', 'RUMANIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pruebas`
--

CREATE TABLE `pruebas` (
  `codPrueba` char(5) NOT NULL,
  `nombrePrueba` varchar(40) DEFAULT NULL,
  `nombreDeporte` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pruebas`
--

INSERT INTO `pruebas` (`codPrueba`, `nombrePrueba`, `nombreDeporte`) VALUES
('100ME', 'Cien Metros Vallas', 'Atletismo'),
('FINBA', 'Final NBA', 'Baloncesto'),
('OLIMP', 'Olimpiadas', 'Fútbol'),
('UEFAS', 'UEFA', 'Fútbol');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `deportistas`
--
ALTER TABLE `deportistas`
  ADD PRIMARY KEY (`codDeportista`),
  ADD UNIQUE KEY `dniDeportista` (`dniDeportista`),
  ADD KEY `FK_paisDeportista` (`paisDeportista`);

--
-- Indices de la tabla `medallas`
--
ALTER TABLE `medallas`
  ADD PRIMARY KEY (`codPrueba`,`fechaMedalla`),
  ADD KEY `FK_codDeportista` (`codDeportista`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`codPais`);

--
-- Indices de la tabla `pruebas`
--
ALTER TABLE `pruebas`
  ADD PRIMARY KEY (`codPrueba`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `deportistas`
--
ALTER TABLE `deportistas`
  MODIFY `codDeportista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `deportistas`
--
ALTER TABLE `deportistas`
  ADD CONSTRAINT `FK_paisDeportista` FOREIGN KEY (`paisDeportista`) REFERENCES `paises` (`codPais`);

--
-- Filtros para la tabla `medallas`
--
ALTER TABLE `medallas`
  ADD CONSTRAINT `FK_codDeportista` FOREIGN KEY (`codDeportista`) REFERENCES `deportistas` (`codDeportista`),
  ADD CONSTRAINT `FK_codPrueba` FOREIGN KEY (`codPrueba`) REFERENCES `pruebas` (`codPrueba`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
