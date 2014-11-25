-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2014 a las 04:22:44
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `spadamaris`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `activarCliente`(IN ID INT)
BEGIN
	UPDATE Cliente SET Activo="S" WHERE IDCliente=ID AND Activo = 'N';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `activarEmpleado`(IN ID INT)
BEGIN
	UPDATE Empleado SET Activo="S" WHERE IDEmpleado=ID AND Activo = 'N';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `activarProductoServicio`(IN ID INT)
BEGIN
	UPDATE ProductoServicio SET Activo="S" WHERE IDProductoServicio=ID AND Activo = 'N';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `activarProveedor`(IN ID INT)
BEGIN
	UPDATE Proveedor SET Activo="S" WHERE IDProveedor=ID AND Activo = 'N';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `desactivarCliente`(IN ID INT)
BEGIN
	UPDATE Cliente SET Activo="N" WHERE IDCliente=ID AND Activo = 'S';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `desactivarEmpleado`(IN ID INT)
BEGIN
	UPDATE Empleado SET Activo="N" WHERE IDEmpleado=ID AND Activo = 'S';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `desactivarProductoServicio`(IN ID INT)
BEGIN
	UPDATE ProductoServicio SET Activo="N" WHERE IDProductoServicio=ID AND Activo = 'S';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `desactivarProveedor`(IN ID INT)
BEGIN
	UPDATE Proveedor SET Activo="N" WHERE IDProveedor=ID AND Activo = 'S';
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AguaAlDia`
--

CREATE TABLE IF NOT EXISTS `AguaAlDia` (
`IDAguaAlDia` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Poca` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Regular` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Mucha` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `AguaAlDia`
--

INSERT INTO `AguaAlDia` (`IDAguaAlDia`, `IDHistorialMedico`, `Poca`, `Regular`, `Mucha`) VALUES
(1, 1, 'S', '', ''),
(2, 2, 'S', '', ''),
(3, 3, 'S', '', ''),
(4, 4, 'S', '', ''),
(5, 5, '', '', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AjusteEntrada`
--

CREATE TABLE IF NOT EXISTS `AjusteEntrada` (
`IDAjusteEntrada` int(10) NOT NULL,
  `IDMovimientoAlmacen` int(10) NOT NULL,
  `IDAjusteEntradaTipo` int(10) NOT NULL,
  `IDCliente` int(10) DEFAULT NULL,
  `Folio` int(10) NOT NULL,
  `Total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `Observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `AjusteEntrada`
--

INSERT INTO `AjusteEntrada` (`IDAjusteEntrada`, `IDMovimientoAlmacen`, `IDAjusteEntradaTipo`, `IDCliente`, `Folio`, `Total`, `Observaciones`) VALUES
(1, 11, 1, NULL, 1, '0.00', NULL),
(2, 23, 1, 1, 2, '0.00', 'fadsfas'),
(3, 25, 1, 1, 3, '0.00', 'fadfsd'),
(4, 28, 1, 1, 4, '0.00', 'fasdfs'),
(5, 29, 1, 1, 5, '0.00', 'fadfasd'),
(7, 31, 1, 1, 6, '0.00', 'fdasdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AjusteEntradaDetalle`
--

CREATE TABLE IF NOT EXISTS `AjusteEntradaDetalle` (
`IDAjusteEntradaDetalle` int(10) NOT NULL,
  `IDAjusteEntrada` int(10) NOT NULL,
  `IDProductoServicio` int(10) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL,
  `PrecioUnitario` decimal(10,2) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `AjusteEntradaDetalle`
--

INSERT INTO `AjusteEntradaDetalle` (`IDAjusteEntradaDetalle`, `IDAjusteEntrada`, `IDProductoServicio`, `Cantidad`, `PrecioUnitario`) VALUES
(1, 1, 1, '5.00', '0.00'),
(2, 1, 2, '10.00', '0.00'),
(3, 4, 1, '3.00', '0.00'),
(4, 4, 2, '6.00', '0.00'),
(5, 5, 1, '1.00', '0.00'),
(6, 5, 2, '1.00', '0.00'),
(7, 7, 1, '1.00', '15.50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AjusteEntradaTipo`
--

CREATE TABLE IF NOT EXISTS `AjusteEntradaTipo` (
`IDAjusteEntradaTipo` int(10) NOT NULL,
  `Tipo` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ExclusivoSistema` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `AjusteEntradaTipo`
--

INSERT INTO `AjusteEntradaTipo` (`IDAjusteEntradaTipo`, `Tipo`, `ExclusivoSistema`, `Descripcion`) VALUES
(1, 'Entrada por Devolución', 'N', 'Mercancía que nos regresa un Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AjusteSalida`
--

CREATE TABLE IF NOT EXISTS `AjusteSalida` (
`IDAjusteSalida` int(10) NOT NULL,
  `IDMovimientoAlmacen` int(10) NOT NULL,
  `IDAjusteSalidaTipo` int(10) NOT NULL,
  `IDProveedor` int(10) DEFAULT NULL,
  `Folio` int(10) NOT NULL,
  `Total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `Observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `AjusteSalida`
--

INSERT INTO `AjusteSalida` (`IDAjusteSalida`, `IDMovimientoAlmacen`, `IDAjusteSalidaTipo`, `IDProveedor`, `Folio`, `Total`, `Observaciones`) VALUES
(1, 24, 1, 1, 0, '0.00', 'puto'),
(2, 26, 1, 1, 1, '0.00', 'fasdfasd'),
(3, 27, 1, 1, 2, '0.00', 'fasdfasdf'),
(4, 32, 1, 1, 3, '0.00', 'fasdfs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AjusteSalidaDetalle`
--

CREATE TABLE IF NOT EXISTS `AjusteSalidaDetalle` (
`IDAjusteSalidaDetalle` int(10) NOT NULL,
  `IDAjusteSalida` int(10) NOT NULL,
  `IDProductoServicio` int(10) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL,
  `PrecioUnitario` decimal(10,2) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `AjusteSalidaDetalle`
--

INSERT INTO `AjusteSalidaDetalle` (`IDAjusteSalidaDetalle`, `IDAjusteSalida`, `IDProductoServicio`, `Cantidad`, `PrecioUnitario`) VALUES
(1, 1, 1, '10.00', '0.00'),
(2, 3, 1, '4.00', '0.00'),
(3, 3, 2, '1.00', '0.00'),
(4, 4, 1, '3.00', '15.50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AjusteSalidaTipo`
--

CREATE TABLE IF NOT EXISTS `AjusteSalidaTipo` (
`IDAjusteSalidaTipo` int(10) NOT NULL,
  `Tipo` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ExclusivoSistema` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `AjusteSalidaTipo`
--

INSERT INTO `AjusteSalidaTipo` (`IDAjusteSalidaTipo`, `Tipo`, `ExclusivoSistema`, `Descripcion`) VALUES
(1, 'Salida por Devolución', 'N', 'Mercancía que se regresa al Proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Alimentacion`
--

CREATE TABLE IF NOT EXISTS `Alimentacion` (
`IDAlimentacion` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Buena` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Regular` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Mala` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `Alimentacion`
--

INSERT INTO `Alimentacion` (`IDAlimentacion`, `IDHistorialMedico`, `Buena`, `Regular`, `Mala`) VALUES
(1, 1, '', 'S', ''),
(2, 2, '', 'S', ''),
(3, 3, '', '', 'S'),
(4, 4, '', '', 'S'),
(5, 5, 'S', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cargo`
--

CREATE TABLE IF NOT EXISTS `Cargo` (
`IDCargo` int(10) NOT NULL,
  `Cargo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `Cargo`
--

INSERT INTO `Cargo` (`IDCargo`, `Cargo`, `Descripcion`) VALUES
(1, 'Administrador', 'Encargado de las Operaciones Del Sistema'),
(2, 'Terapeuta', 'Encargado de Atender a Los Pacientes en Las Consultas y Autorizado para Vender Producto'),
(3, 'Empleado', 'es el encargado de atender a los cliente y proveedores en las compras y ventas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cliente`
--

CREATE TABLE IF NOT EXISTS `Cliente` (
`IDCliente` int(10) NOT NULL,
  `Nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ApellidoPaterno` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ApellidoMaterno` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Calle` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `NumExterior` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `NumInterior` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Colonia` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `CodigoPostal` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefono` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Celular` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Activo` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'S'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Cliente`
--

INSERT INTO `Cliente` (`IDCliente`, `Nombre`, `ApellidoPaterno`, `ApellidoMaterno`, `Calle`, `NumExterior`, `NumInterior`, `Colonia`, `CodigoPostal`, `Email`, `Telefono`, `Celular`, `Activo`) VALUES
(1, 'Christian', 'Velázquez', 'Pérez', 'Volcán Usulutan', '55', '3', 'Huentitán el Bajo', '44250', 'chris_abimael@hotmail.com', '36516998', '3310180877', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Consulta`
--

CREATE TABLE IF NOT EXISTS `Consulta` (
`IDConsulta` int(10) NOT NULL,
  `IDCliente` int(10) NOT NULL,
  `IDTerapeuta` int(10) NOT NULL,
  `IDHistorialMedico` int(10) DEFAULT NULL,
  `IDServicio` int(10) unsigned NOT NULL,
  `FechaCita` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IDConsultaStatus` int(10) NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `Consulta`
--

INSERT INTO `Consulta` (`IDConsulta`, `IDCliente`, `IDTerapeuta`, `IDHistorialMedico`, `IDServicio`, `FechaCita`, `IDConsultaStatus`, `observaciones`) VALUES
(5, 1, 2, 0, 3, '2014-11-03 06:00:00', 2, 'hola esta es una consulta'),
(6, 1, 2, 0, 0, '2014-11-23 20:26:36', 2, 'se termino'),
(7, 1, 2, 0, 0, '2014-10-30 20:45:31', 1, 'fasdfasd'),
(8, 1, 2, NULL, 3, '2014-10-28 20:50:05', 1, 'fasdfasdf puto'),
(9, 1, 2, 0, 3, '2014-12-25 19:00:00', 1, 'mi consulta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ConsultaStatus`
--

CREATE TABLE IF NOT EXISTS `ConsultaStatus` (
`IDConsultaStatus` int(10) NOT NULL,
  `Status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `ConsultaStatus`
--

INSERT INTO `ConsultaStatus` (`IDConsultaStatus`, `Status`, `Descripcion`) VALUES
(1, 'Cliente Iniciado', 'Cliente que empezo su terapia'),
(2, 'Cliente Finalizado', 'Cliente que termino su terapia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Empleado`
--

CREATE TABLE IF NOT EXISTS `Empleado` (
`IDEmpleado` int(10) NOT NULL,
  `Nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ApellidoPaterno` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ApellidoMaterno` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Usuario` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Contrasena` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `IDCargo` int(10) NOT NULL,
  `Calle` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `NumExterior` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `NumInterior` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Colonia` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `CodigoPostal` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `Foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Telefono` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Celular` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Activo` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'S'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `Empleado`
--

INSERT INTO `Empleado` (`IDEmpleado`, `Nombre`, `ApellidoPaterno`, `ApellidoMaterno`, `Usuario`, `Contrasena`, `IDCargo`, `Calle`, `NumExterior`, `NumInterior`, `Colonia`, `CodigoPostal`, `Foto`, `Email`, `Telefono`, `Celular`, `Activo`) VALUES
(1, 'ramon', 'lozano', 'franco', 'rmn528', '1234', 1, 'obolo', '3973', NULL, 'lago de oriente', '44790', NULL, '', NULL, NULL, 'S'),
(2, 'paco', 'lalala', 'alalal', 'paco', '1234', 2, 'fsdfasd', '22222', NULL, 'fasdfas', '44790', NULL, '', NULL, NULL, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EmpleadoSueldo`
--

CREATE TABLE IF NOT EXISTS `EmpleadoSueldo` (
`IDEmpleadoSueldo` int(11) NOT NULL,
  `IDEmpleado` int(11) NOT NULL,
  `FechaSueldo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sueldo` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Exfoliacion`
--

CREATE TABLE IF NOT EXISTS `Exfoliacion` (
`IDExfoliacion` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `PeelingQuimico` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Laser` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Dermoabrasion` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RetinA` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Renova` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Racutan` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Adapaleno` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AcidoGlicolico` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AlfaHidroxiacidos` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ExfolianteGranuloso` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AcidoLactico` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VitaminaA` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BlanqueadorOAclarador` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `Exfoliacion`
--

INSERT INTO `Exfoliacion` (`IDExfoliacion`, `IDHistorialMedico`, `PeelingQuimico`, `Laser`, `Dermoabrasion`, `RetinA`, `Renova`, `Racutan`, `Adapaleno`, `AcidoGlicolico`, `AlfaHidroxiacidos`, `ExfolianteGranuloso`, `AcidoLactico`, `VitaminaA`, `BlanqueadorOAclarador`) VALUES
(1, 1, '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 2, '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, 3, '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 4, 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S'),
(5, 5, 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Existencia`
--

CREATE TABLE IF NOT EXISTS `Existencia` (
`IDExistencia` int(10) NOT NULL,
  `FechaReferencia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IDProductoServicio` int(10) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ExploracionFinal`
--

CREATE TABLE IF NOT EXISTS `ExploracionFinal` (
`IDExploracionFinal` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `PesoFinal` decimal(10,3) DEFAULT NULL,
  `BustoFinal` decimal(10,3) DEFAULT NULL,
  `DiafragmaFinal` decimal(10,3) DEFAULT NULL,
  `BrazoFinal` decimal(10,3) DEFAULT NULL,
  `CinturaFinal` decimal(10,3) DEFAULT NULL,
  `AbdomenFinal` decimal(10,3) DEFAULT NULL,
  `CaderaFinal` decimal(10,3) DEFAULT NULL,
  `MusloFinal` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `ExploracionFinal`
--

INSERT INTO `ExploracionFinal` (`IDExploracionFinal`, `IDHistorialMedico`, `PesoFinal`, `BustoFinal`, `DiafragmaFinal`, `BrazoFinal`, `CinturaFinal`, `AbdomenFinal`, `CaderaFinal`, `MusloFinal`) VALUES
(1, 1, '10.000', '10.000', '10.000', '10.000', '10.000', '10.000', '101.000', '10.000'),
(2, 2, '10.000', '10.000', '10.000', '10.000', '10.000', '10.000', '101.000', '10.000'),
(3, 3, '10.000', '101.000', '10.000', '10.000', '10.000', '10.000', '10.000', '10.000'),
(4, 4, '10.000', '101.000', '10.000', '10.000', '10.000', '10.000', '10.000', '10.000'),
(5, 5, '11.000', '11.000', '11.000', '11.000', '11.000', '1.000', '111.000', '11.000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ExploracionInicial`
--

CREATE TABLE IF NOT EXISTS `ExploracionInicial` (
`IDExploracionInicial` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `PesoInicial` decimal(10,3) DEFAULT NULL,
  `BustoInicial` decimal(10,3) DEFAULT NULL,
  `DiafragmaInicial` decimal(10,3) DEFAULT NULL,
  `BrazoInicial` decimal(10,3) DEFAULT NULL,
  `CinturaInicial` decimal(10,3) DEFAULT NULL,
  `AbdomenInicial` decimal(10,3) DEFAULT NULL,
  `CaderaInicial` decimal(10,3) DEFAULT NULL,
  `MusloInicial` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `ExploracionInicial`
--

INSERT INTO `ExploracionInicial` (`IDExploracionInicial`, `IDHistorialMedico`, `PesoInicial`, `BustoInicial`, `DiafragmaInicial`, `BrazoInicial`, `CinturaInicial`, `AbdomenInicial`, `CaderaInicial`, `MusloInicial`) VALUES
(1, 1, '100.000', '10.000', '10.000', '10.000', '10.000', '10.000', '11.000', '10.000'),
(2, 2, '100.000', '10.000', '10.000', '10.000', '10.000', '10.000', '10.000', '10.000'),
(3, 3, '10.000', '10.000', '10.000', '10.000', '10.000', '10.000', '10.000', '10.000'),
(4, 4, '10.000', '10.000', '10.000', '10.000', '10.000', '10.000', '10.000', '10.000'),
(5, 5, '11.000', '11.000', '11.000', '11.000', '11.000', '11.000', '1.000', '11.000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FichaClinica`
--

CREATE TABLE IF NOT EXISTS `FichaClinica` (
`IDFichaClinica` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `MotivoConsulta` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `TiempoProblema` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `RelacionaCon` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `TratamientoAnterior` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `MetodosProbados` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `ResultadosAnteriores` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `FichaClinica`
--

INSERT INTO `FichaClinica` (`IDFichaClinica`, `IDHistorialMedico`, `MotivoConsulta`, `TiempoProblema`, `RelacionaCon`, `TratamientoAnterior`, `MetodosProbados`, `ResultadosAnteriores`) VALUES
(1, 1, 'fadfasdfasdfasdf', '', '', '', '', ''),
(2, 2, '', '', '', '', '', ''),
(3, 3, 'fasdfsdf', 'fasdf', 'fasdf', 'f', 'fasdf', 'afsdfas'),
(4, 4, 'fasdfsdf', 'fasdf', 'fasdf', 'f', 'fasdf', 'afsdfas'),
(5, 5, 'gdfasd', 'fasdfsad', 'fasdfsfd', 'f', 'fadfasd', 'fasdfasd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Habito`
--

CREATE TABLE IF NOT EXISTS `Habito` (
`IDHabito` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Fumar` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ejercicio` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UsarFaja` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Suenio` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TomaSol` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Bloqueador` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Hidroquinona` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `Habito`
--

INSERT INTO `Habito` (`IDHabito`, `IDHistorialMedico`, `Fumar`, `Ejercicio`, `UsarFaja`, `Suenio`, `TomaSol`, `Bloqueador`, `Hidroquinona`) VALUES
(1, 1, '', '', '', '', '', '', ''),
(2, 2, '', '', '', '', '', '', ''),
(3, 3, '', '', '', '', '', '', ''),
(4, 4, '', '', '', '', '', '', ''),
(5, 5, 'S', 'S', 'S', 'S', 'S', 'S', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `HistorialMedico`
--

CREATE TABLE IF NOT EXISTS `HistorialMedico` (
`IDHistorialMedico` int(10) NOT NULL,
  `IDCliente` int(10) NOT NULL,
  `FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IDServicio` int(10) NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `HistorialMedico`
--

INSERT INTO `HistorialMedico` (`IDHistorialMedico`, `IDCliente`, `FechaRegistro`, `IDServicio`, `observaciones`) VALUES
(1, 1, '2014-11-24 04:51:30', 3, 'fasdfads'),
(2, 1, '2014-11-24 04:51:36', 3, 'fasdfads'),
(3, 1, '2014-11-24 05:21:36', 4, 'dfasdfa'),
(4, 1, '2014-11-24 05:21:43', 4, 'dfasdfa'),
(5, 1, '2014-11-24 05:38:49', 4, 'fasdfas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `MovimientoAlmacen`
--

CREATE TABLE IF NOT EXISTS `MovimientoAlmacen` (
`IDMovimientoAlmacen` int(10) NOT NULL,
  `IDMovimientoAlmacenTipo` int(10) NOT NULL,
  `MovimientoAlmacenFecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IDEmpleado` int(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `MovimientoAlmacen`
--

INSERT INTO `MovimientoAlmacen` (`IDMovimientoAlmacen`, `IDMovimientoAlmacenTipo`, `MovimientoAlmacenFecha`, `IDEmpleado`) VALUES
(9, 3, '2014-11-17 20:16:05', 1),
(10, 4, '2014-11-17 20:16:05', 1),
(11, 1, '2014-11-17 20:16:05', 1),
(18, 4, '2014-11-18 00:01:14', 1),
(19, 4, '2014-11-18 00:11:05', 1),
(20, 4, '2014-11-18 00:11:26', 1),
(21, 4, '2014-11-18 00:13:30', 1),
(22, 3, '2014-11-24 00:57:15', 1),
(23, 1, '2014-11-24 04:28:37', 1),
(24, 2, '2014-11-24 04:29:44', 1),
(25, 1, '2014-11-24 04:30:54', 1),
(26, 2, '2014-11-24 16:28:57', 1),
(27, 2, '2014-11-24 16:32:09', 1),
(28, 1, '2014-11-24 16:33:52', 1),
(29, 1, '2014-11-24 16:40:30', 1),
(31, 1, '2014-11-24 16:55:27', 1),
(32, 2, '2014-11-24 16:59:34', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `MovimientoAlmacenTipo`
--

CREATE TABLE IF NOT EXISTS `MovimientoAlmacenTipo` (
`IDMovimientoAlmacenTipo` int(10) NOT NULL,
  `TipoMovimientoAlmacen` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `EntradaSalida` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `MovimientoAlmacenTipo`
--

INSERT INTO `MovimientoAlmacenTipo` (`IDMovimientoAlmacenTipo`, `TipoMovimientoAlmacen`, `EntradaSalida`, `Descripcion`) VALUES
(1, 'Ajuste de Entrada', 'E', 'Entrada de Mercancía al Almacén'),
(2, 'Ajuste de Salida', 'S', 'Salida de Mercancía del Almacén'),
(3, 'Remision', 'S', 'Venta de Mercancía'),
(4, 'Recepcion', 'E', 'Compra de Mercancía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Padecimiento`
--

CREATE TABLE IF NOT EXISTS `Padecimiento` (
`IDPadecimiento` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Diabetes` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Obesisdad` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Depresion` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Estres` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sobrepeso` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Estrenimiento` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Colitis` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RetencionLiquidos` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TranstornosMenstruales` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CuidadosCorporales` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Embarazo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `Padecimiento`
--

INSERT INTO `Padecimiento` (`IDPadecimiento`, `IDHistorialMedico`, `Diabetes`, `Obesisdad`, `Depresion`, `Estres`, `Sobrepeso`, `Estrenimiento`, `Colitis`, `RetencionLiquidos`, `TranstornosMenstruales`, `CuidadosCorporales`, `Embarazo`) VALUES
(1, 1, '', '', '', '', '', '', '', '', '', '', NULL),
(2, 2, '', '', '', '', '', '', '', '', '', '', NULL),
(3, 3, '', '', '', '', '', '', '', '', '', '', NULL),
(4, 4, '', '', '', '', '', '', '', '', '', '', NULL),
(5, 5, 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Piel`
--

CREATE TABLE IF NOT EXISTS `Piel` (
`IDPiel` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Fina` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Gruesa` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Deshidratada` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Flacida` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Seca` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Mixta` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Grasa` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Acneica` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Manchas` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Cicatrices` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PoroAbierto` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ojeras` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Lunares` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pecas` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PuntosNegros` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Verrugas` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Arrugas` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BrilloFacial` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PielAsfixiada` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Despigmentacion` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `Piel`
--

INSERT INTO `Piel` (`IDPiel`, `IDHistorialMedico`, `Fina`, `Gruesa`, `Deshidratada`, `Flacida`, `Seca`, `Mixta`, `Grasa`, `Acneica`, `Manchas`, `Cicatrices`, `PoroAbierto`, `Ojeras`, `Lunares`, `Pecas`, `PuntosNegros`, `Verrugas`, `Arrugas`, `BrilloFacial`, `PielAsfixiada`, `Despigmentacion`) VALUES
(1, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 2, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, 3, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 4, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, 5, 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ProductoServicio`
--

CREATE TABLE IF NOT EXISTS `ProductoServicio` (
`IDProductoServicio` int(10) NOT NULL,
  `IDProductoServicioTipo` int(10) NOT NULL,
  `Producto` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `Foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Activo` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'S'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `ProductoServicio`
--

INSERT INTO `ProductoServicio` (`IDProductoServicio`, `IDProductoServicioTipo`, `Producto`, `PrecioUnitario`, `Foto`, `Descripcion`, `Activo`) VALUES
(1, 1, 'Crema', '15.50', NULL, NULL, 'S'),
(2, 1, 'Toalla', '50.00', NULL, NULL, 'S'),
(3, 2, 'Baño de Juva', '200.00', NULL, NULL, 'S'),
(4, 2, 'Pedicure', '150.99', NULL, NULL, 'S'),
(5, 2, 'masaje', '3.00', 'JarvanIV_0.jpg', 'jarva IV', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ProductoServicioTipo`
--

CREATE TABLE IF NOT EXISTS `ProductoServicioTipo` (
`IDProductoServicioTipo` int(10) NOT NULL,
  `ProductoServicioTipo` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `ProductoServicioTipo`
--

INSERT INTO `ProductoServicioTipo` (`IDProductoServicioTipo`, `ProductoServicioTipo`, `Descripcion`) VALUES
(1, 'Producto', 'Mercancía que ofrecemos al cliente'),
(2, 'Servicio', 'Todo aquel trabajo realizado, por ejemplo: las terapias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Proveedor`
--

CREATE TABLE IF NOT EXISTS `Proveedor` (
`IDProveedor` int(10) NOT NULL,
  `Nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ApellidoPaterno` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ApellidoMaterno` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `RFC` char(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Calle` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `NumExterior` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `NumInterior` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Colonia` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `CodigoPostal` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefono` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Celular` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Activo` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'S'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `Proveedor`
--

INSERT INTO `Proveedor` (`IDProveedor`, `Nombre`, `ApellidoPaterno`, `ApellidoMaterno`, `RFC`, `Calle`, `NumExterior`, `NumInterior`, `Colonia`, `CodigoPostal`, `Email`, `Telefono`, `Celular`, `Activo`) VALUES
(1, 'Paco', 'Matrinez', 'Jiménez', NULL, 'Periférico Norte', '2341', '2', 'San Ignacio', '44550', NULL, NULL, NULL, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Recepcion`
--

CREATE TABLE IF NOT EXISTS `Recepcion` (
`IDRecepcion` int(10) NOT NULL,
  `IDMovimientoAlmacen` int(10) NOT NULL,
  `IDProveedor` int(10) NOT NULL,
  `Folio` int(10) NOT NULL,
  `FechaRecepcion` date NOT NULL,
  `Total` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `Recepcion`
--

INSERT INTO `Recepcion` (`IDRecepcion`, `IDMovimientoAlmacen`, `IDProveedor`, `Folio`, `FechaRecepcion`, `Total`) VALUES
(1, 10, 1, 2, '2014-11-14', '0.00'),
(7, 18, 1, 3, '2014-11-18', '150.00'),
(8, 19, 1, 4, '2014-11-17', '0.00'),
(9, 20, 1, 5, '2014-11-17', '0.00'),
(10, 21, 1, 6, '2014-11-17', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RecepcionDetalle`
--

CREATE TABLE IF NOT EXISTS `RecepcionDetalle` (
`IDRecepcionDetalle` int(10) NOT NULL,
  `IDRecepcion` int(10) NOT NULL,
  `IDProducto` int(10) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `IVA` decimal(10,2) NOT NULL,
  `Descuento` decimal(10,2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `RecepcionDetalle`
--

INSERT INTO `RecepcionDetalle` (`IDRecepcionDetalle`, `IDRecepcion`, `IDProducto`, `Cantidad`, `PrecioUnitario`, `IVA`, `Descuento`) VALUES
(1, 7, 1, '3.00', '50.00', '16.00', '10.00'),
(2, 8, 1, '2.00', '0.00', '16.00', '0.00'),
(3, 8, 2, '1.00', '0.00', '16.00', '0.00'),
(4, 9, 1, '2.00', '0.00', '16.00', '0.00'),
(5, 9, 2, '1.00', '0.00', '16.00', '0.00'),
(6, 10, 1, '6.00', '0.00', '16.00', '0.00'),
(7, 10, 2, '2.00', '0.00', '16.00', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Remision`
--

CREATE TABLE IF NOT EXISTS `Remision` (
`IDRemision` int(10) NOT NULL,
  `IDMovimientoAlmacen` int(10) NOT NULL,
  `IDCliente` int(10) NOT NULL,
  `Folio` int(10) NOT NULL,
  `FechaRemision` date NOT NULL,
  `Total` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `Remision`
--

INSERT INTO `Remision` (`IDRemision`, `IDMovimientoAlmacen`, `IDCliente`, `Folio`, `FechaRemision`, `Total`) VALUES
(11, 9, 1, 1, '2014-11-15', '0.00'),
(12, 22, 1, 2, '2014-11-19', '285.94');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RemisionDetalle`
--

CREATE TABLE IF NOT EXISTS `RemisionDetalle` (
`IDRemisionDetalle` int(10) NOT NULL,
  `IDRemision` int(10) NOT NULL,
  `IDProducto` int(10) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `IVA` decimal(10,2) NOT NULL,
  `Descuento` decimal(10,2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `RemisionDetalle`
--

INSERT INTO `RemisionDetalle` (`IDRemisionDetalle`, `IDRemision`, `IDProducto`, `Cantidad`, `PrecioUnitario`, `IVA`, `Descuento`) VALUES
(1, 11, 1, '5.00', '50.00', '0.00', '0.00'),
(2, 12, 1, '3.00', '15.50', '16.00', '0.00'),
(3, 12, 2, '4.00', '50.00', '16.00', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoCelulitis`
--

CREATE TABLE IF NOT EXISTS `TipoCelulitis` (
`IDTipoCelulitis` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Fibrosa` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Edematosa` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Flacida` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Dura` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Mixta` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Dolorosa` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `TipoCelulitis`
--

INSERT INTO `TipoCelulitis` (`IDTipoCelulitis`, `IDHistorialMedico`, `Fibrosa`, `Edematosa`, `Flacida`, `Dura`, `Mixta`, `Dolorosa`) VALUES
(1, 1, '', '', '', '', '', ''),
(2, 2, '', '', '', '', '', ''),
(3, 3, '', '', '', '', '', ''),
(4, 4, '', '', '', '', '', ''),
(5, 5, 'S', 'S', 'S', 'S', 'S', 'S');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ajusteentrada`
--
CREATE TABLE IF NOT EXISTS `v_ajusteentrada` (
`IDAjusteEntrada` int(10)
,`IDMovimientoAlmacen` int(10)
,`Folio` int(10)
,`IDAjusteEntradaTipo` int(10)
,`Tipo` varchar(60)
,`IDCliente` int(10)
,`Cliente` varchar(92)
,`IDEmpleado` int(10)
,`Empleado` varchar(92)
,`Total` decimal(10,2) unsigned
,`Observaciones` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ajusteentradadetalle`
--
CREATE TABLE IF NOT EXISTS `v_ajusteentradadetalle` (
`IDAjusteEntradaDetalle` int(10)
,`IDAjusteEntrada` int(10)
,`IDProductoServicio` int(10)
,`Producto` varchar(30)
,`Cantidad` decimal(10,2)
,`PrecioUnitario` decimal(10,2) unsigned
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ajustesalida`
--
CREATE TABLE IF NOT EXISTS `v_ajustesalida` (
`IDAjusteSalida` int(10)
,`IDMovimientoAlmacen` int(10)
,`Folio` int(10)
,`IDAjusteSalidaTipo` int(10)
,`Tipo` varchar(60)
,`IDProveedor` int(10)
,`Proveedor` varchar(92)
,`IDEmpleado` int(10)
,`Empleado` varchar(92)
,`Total` decimal(10,2) unsigned
,`Observaciones` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ajustesalidadetalle`
--
CREATE TABLE IF NOT EXISTS `v_ajustesalidadetalle` (
`IDAjusteSalidaDetalle` int(10)
,`IDAjusteSalida` int(10)
,`IDProductoServicio` int(10)
,`Producto` varchar(30)
,`Cantidad` decimal(10,2)
,`PrecioUnitario` decimal(10,2) unsigned
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_cliente`
--
CREATE TABLE IF NOT EXISTS `v_cliente` (
`IDCliente` int(10)
,`Nombre` varchar(30)
,`ApellidoPaterno` varchar(30)
,`ApellidoMaterno` varchar(30)
,`Calle` varchar(60)
,`NumExterior` varchar(20)
,`NumInterior` varchar(20)
,`Colonia` varchar(60)
,`CP` varchar(5)
,`Email` varchar(30)
,`Telefono` varchar(30)
,`Celular` varchar(30)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_cliente_deleter`
--
CREATE TABLE IF NOT EXISTS `v_cliente_deleter` (
`IDCliente` int(10)
,`Nombre` varchar(30)
,`ApellidoPaterno` varchar(30)
,`ApellidoMaterno` varchar(30)
,`Calle` varchar(60)
,`NumExterior` varchar(20)
,`NumInterior` varchar(20)
,`Colonia` varchar(60)
,`CP` varchar(5)
,`Email` varchar(30)
,`Telefono` varchar(30)
,`Celular` varchar(30)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_consulta`
--
CREATE TABLE IF NOT EXISTS `v_consulta` (
`IDConsulta` int(10)
,`IDCliente` int(10)
,`Cliente` varchar(92)
,`IDTerapeuta` int(10)
,`Terapeuta` varchar(92)
,`IDProductoServicio` int(10)
,`Producto` varchar(30)
,`FechaCita` timestamp
,`IDHistorialMedico` int(10)
,`IDConsultaStatus` int(10)
,`Status` varchar(30)
,`Observaciones` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_empleado`
--
CREATE TABLE IF NOT EXISTS `v_empleado` (
`IDEmpleado` int(10)
,`Nombre` varchar(30)
,`ApellidoPaterno` varchar(30)
,`ApellidoMaterno` varchar(30)
,`Usuario` varchar(40)
,`Contrasena` varchar(40)
,`IDCargo` int(10)
,`Cargo` varchar(30)
,`Calle` varchar(60)
,`NumExterior` varchar(20)
,`NumInterior` varchar(20)
,`Colonia` varchar(60)
,`CP` varchar(5)
,`Foto` varchar(255)
,`Email` varchar(30)
,`Telefono` varchar(30)
,`Celular` varchar(30)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_empleado_deleter`
--
CREATE TABLE IF NOT EXISTS `v_empleado_deleter` (
`IDEmpleado` int(10)
,`Nombre` varchar(30)
,`ApellidoPaterno` varchar(30)
,`ApellidoMaterno` varchar(30)
,`Usuario` varchar(40)
,`Contrasena` varchar(40)
,`IDCargo` int(10)
,`Cargo` varchar(30)
,`Calle` varchar(60)
,`NumExterior` varchar(20)
,`NumInterior` varchar(20)
,`Colonia` varchar(60)
,`CP` varchar(5)
,`Foto` varchar(255)
,`Email` varchar(30)
,`Telefono` varchar(30)
,`Celular` varchar(30)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_existencia`
--
CREATE TABLE IF NOT EXISTS `v_existencia` (
`IDExistencia` int(10)
,`FechaReferencia` timestamp
,`IDProductoServicio` int(10)
,`Producto` varchar(30)
,`PrecioUnitario` decimal(10,2)
,`Cantidad` decimal(10,2)
,`Activo` varchar(1)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_historialmedico`
--
CREATE TABLE IF NOT EXISTS `v_historialmedico` (
`IDHistorialMedico` int(10)
,`IDCliente` int(10)
,`Cliente` varchar(92)
,`FechaRegistro` timestamp
,`IDServicio` int(10)
,`Producto` varchar(30)
,`Observaciones` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_producto`
--
CREATE TABLE IF NOT EXISTS `v_producto` (
`IDProductoServicio` int(10)
,`IDProductoServicioTipo` int(10)
,`ProductoServicioTipo` varchar(60)
,`Producto` varchar(30)
,`PrecioUnitario` decimal(10,2)
,`Foto` varchar(255)
,`Descripcion` varchar(100)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_producto_deleter`
--
CREATE TABLE IF NOT EXISTS `v_producto_deleter` (
`IDProductoServicio` int(10)
,`IDProductoServicioTipo` int(10)
,`ProductoServicioTipo` varchar(60)
,`Producto` varchar(30)
,`PrecioUnitario` decimal(10,2)
,`Foto` varchar(255)
,`Descripcion` varchar(100)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_proveedor`
--
CREATE TABLE IF NOT EXISTS `v_proveedor` (
`IDProveedor` int(10)
,`Nombre` varchar(30)
,`ApellidoPaterno` varchar(30)
,`ApellidoMaterno` varchar(30)
,`RFC` char(13)
,`Calle` varchar(60)
,`NumExterior` varchar(20)
,`NumInterior` varchar(20)
,`Colonia` varchar(60)
,`CP` varchar(5)
,`Email` varchar(30)
,`Telefono` varchar(30)
,`Celular` varchar(30)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_proveedor_deleter`
--
CREATE TABLE IF NOT EXISTS `v_proveedor_deleter` (
`IDProveedor` int(10)
,`Nombre` varchar(30)
,`ApellidoPaterno` varchar(30)
,`ApellidoMaterno` varchar(30)
,`RFC` char(13)
,`Calle` varchar(60)
,`NumExterior` varchar(20)
,`NumInterior` varchar(20)
,`Colonia` varchar(60)
,`CP` varchar(5)
,`Email` varchar(30)
,`Telefono` varchar(30)
,`Celular` varchar(30)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_recepcion`
--
CREATE TABLE IF NOT EXISTS `v_recepcion` (
`IDRecepcion` int(10)
,`IDMovimientoAlmacen` int(10)
,`Folio` int(10)
,`IDProveedor` int(10)
,`Proveedor` varchar(92)
,`IDEmpleado` int(10)
,`Empleado` varchar(92)
,`FechaRecepcion` date
,`Total` decimal(10,2)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_recepciondetalle`
--
CREATE TABLE IF NOT EXISTS `v_recepciondetalle` (
`IDRecepcionDetalle` int(10)
,`IDRecepcion` int(10)
,`IDProducto` int(10)
,`Producto` varchar(30)
,`Cantidad` decimal(10,2)
,`PrecioUnitario` decimal(10,2)
,`IVA` decimal(10,2)
,`Descuento` decimal(10,2)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_remision`
--
CREATE TABLE IF NOT EXISTS `v_remision` (
`IDRemision` int(10)
,`IDMovimientoAlmacen` int(10)
,`Folio` int(10)
,`IDCliente` int(10)
,`Cliente` varchar(92)
,`IDEmpleado` int(10)
,`Empleado` varchar(92)
,`FechaRemision` date
,`Total` decimal(10,2)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_remisiondetalle`
--
CREATE TABLE IF NOT EXISTS `v_remisiondetalle` (
`IDRemisionDetalle` int(10)
,`IDRemision` int(10)
,`IDProducto` int(10)
,`Producto` varchar(30)
,`Cantidad` decimal(10,2)
,`PrecioUnitario` decimal(10,2)
,`IVA` decimal(10,2)
,`Descuento` decimal(10,2)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_servicio`
--
CREATE TABLE IF NOT EXISTS `v_servicio` (
`IDProductoServicio` int(10)
,`IDProductoServicioTipo` int(10)
,`ProductoServicioTipo` varchar(60)
,`Producto` varchar(30)
,`PrecioUnitario` decimal(10,2)
,`Foto` varchar(255)
,`Descripcion` varchar(100)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_servicio_deleter`
--
CREATE TABLE IF NOT EXISTS `v_servicio_deleter` (
`IDProductoServicio` int(10)
,`IDProductoServicioTipo` int(10)
,`ProductoServicioTipo` varchar(60)
,`Producto` varchar(30)
,`PrecioUnitario` decimal(10,2)
,`Foto` varchar(255)
,`Descripcion` varchar(100)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_totalcomprado`
--
CREATE TABLE IF NOT EXISTS `v_totalcomprado` (
`Producto` varchar(30)
,`PrecioUnitario` decimal(10,2)
,`CantidadTotalComprada` decimal(32,2)
,`FechaCompra` varchar(10)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_totalvendido`
--
CREATE TABLE IF NOT EXISTS `v_totalvendido` (
`Producto` varchar(30)
,`PrecioUnitario` decimal(10,2)
,`CantidadTotalVendida` decimal(32,2)
,`FechaVenta` varchar(10)
);
-- --------------------------------------------------------

--
-- Estructura para la vista `v_ajusteentrada`
--
DROP TABLE IF EXISTS `v_ajusteentrada`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ajusteentrada` AS select `ae`.`IDAjusteEntrada` AS `IDAjusteEntrada`,`ae`.`IDMovimientoAlmacen` AS `IDMovimientoAlmacen`,`ae`.`Folio` AS `Folio`,`ae`.`IDAjusteEntradaTipo` AS `IDAjusteEntradaTipo`,`aet`.`Tipo` AS `Tipo`,`c`.`IDCliente` AS `IDCliente`,concat_ws(' ',`c`.`Nombre`,`c`.`ApellidoPaterno`,`c`.`ApellidoMaterno`) AS `Cliente`,`e`.`IDEmpleado` AS `IDEmpleado`,concat_ws(' ',`e`.`Nombre`,`e`.`ApellidoPaterno`,`e`.`ApellidoMaterno`) AS `Empleado`,`ae`.`Total` AS `Total`,`ae`.`Observaciones` AS `Observaciones` from ((((`ajusteentrada` `ae` join `ajusteentradatipo` `aet` on((`aet`.`IDAjusteEntradaTipo` = `ae`.`IDAjusteEntradaTipo`))) left join `cliente` `c` on(((`c`.`IDCliente` = `ae`.`IDCliente`) and (`c`.`Activo` = 'S')))) join `movimientoalmacen` `ma` on((`ma`.`IDMovimientoAlmacen` = `ae`.`IDMovimientoAlmacen`))) join `empleado` `e` on(((`ma`.`IDEmpleado` = `e`.`IDEmpleado`) and (`e`.`Activo` = 'S'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ajusteentradadetalle`
--
DROP TABLE IF EXISTS `v_ajusteentradadetalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ajusteentradadetalle` AS select `aed`.`IDAjusteEntradaDetalle` AS `IDAjusteEntradaDetalle`,`aed`.`IDAjusteEntrada` AS `IDAjusteEntrada`,`aed`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`Producto` AS `Producto`,`aed`.`Cantidad` AS `Cantidad`,`aed`.`PrecioUnitario` AS `PrecioUnitario` from (`ajusteentradadetalle` `aed` join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `aed`.`IDProductoServicio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ajustesalida`
--
DROP TABLE IF EXISTS `v_ajustesalida`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ajustesalida` AS select `asa`.`IDAjusteSalida` AS `IDAjusteSalida`,`asa`.`IDMovimientoAlmacen` AS `IDMovimientoAlmacen`,`asa`.`Folio` AS `Folio`,`asa`.`IDAjusteSalidaTipo` AS `IDAjusteSalidaTipo`,`asat`.`Tipo` AS `Tipo`,`p`.`IDProveedor` AS `IDProveedor`,concat_ws(' ',`p`.`Nombre`,`p`.`ApellidoPaterno`,`p`.`ApellidoMaterno`) AS `Proveedor`,`e`.`IDEmpleado` AS `IDEmpleado`,concat_ws(' ',`e`.`Nombre`,`e`.`ApellidoPaterno`,`e`.`ApellidoMaterno`) AS `Empleado`,`asa`.`Total` AS `Total`,`asa`.`Observaciones` AS `Observaciones` from ((((`ajustesalida` `asa` join `ajustesalidatipo` `asat` on((`asat`.`IDAjusteSalidaTipo` = `asa`.`IDAjusteSalidaTipo`))) left join `proveedor` `p` on(((`p`.`IDProveedor` = `asa`.`IDProveedor`) and (`p`.`Activo` = 'S')))) join `movimientoalmacen` `ma` on((`ma`.`IDMovimientoAlmacen` = `asa`.`IDMovimientoAlmacen`))) join `empleado` `e` on(((`ma`.`IDEmpleado` = `e`.`IDEmpleado`) and (`e`.`Activo` = 'S'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ajustesalidadetalle`
--
DROP TABLE IF EXISTS `v_ajustesalidadetalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ajustesalidadetalle` AS select `asd`.`IDAjusteSalidaDetalle` AS `IDAjusteSalidaDetalle`,`asd`.`IDAjusteSalida` AS `IDAjusteSalida`,`asd`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`Producto` AS `Producto`,`asd`.`Cantidad` AS `Cantidad`,`asd`.`PrecioUnitario` AS `PrecioUnitario` from (`ajustesalidadetalle` `asd` join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `asd`.`IDProductoServicio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_cliente`
--
DROP TABLE IF EXISTS `v_cliente`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_cliente` AS select `c`.`IDCliente` AS `IDCliente`,`c`.`Nombre` AS `Nombre`,`c`.`ApellidoPaterno` AS `ApellidoPaterno`,`c`.`ApellidoMaterno` AS `ApellidoMaterno`,`c`.`Calle` AS `Calle`,`c`.`NumExterior` AS `NumExterior`,`c`.`NumInterior` AS `NumInterior`,`c`.`Colonia` AS `Colonia`,`c`.`CodigoPostal` AS `CP`,`c`.`Email` AS `Email`,`c`.`Telefono` AS `Telefono`,`c`.`Celular` AS `Celular` from `cliente` `c` where (`c`.`Activo` = 'S');

-- --------------------------------------------------------

--
-- Estructura para la vista `v_cliente_deleter`
--
DROP TABLE IF EXISTS `v_cliente_deleter`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_cliente_deleter` AS select `c`.`IDCliente` AS `IDCliente`,`c`.`Nombre` AS `Nombre`,`c`.`ApellidoPaterno` AS `ApellidoPaterno`,`c`.`ApellidoMaterno` AS `ApellidoMaterno`,`c`.`Calle` AS `Calle`,`c`.`NumExterior` AS `NumExterior`,`c`.`NumInterior` AS `NumInterior`,`c`.`Colonia` AS `Colonia`,`c`.`CodigoPostal` AS `CP`,`c`.`Email` AS `Email`,`c`.`Telefono` AS `Telefono`,`c`.`Celular` AS `Celular` from `cliente` `c` where (`c`.`Activo` = 'N');

-- --------------------------------------------------------

--
-- Estructura para la vista `v_consulta`
--
DROP TABLE IF EXISTS `v_consulta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_consulta` AS select `con`.`IDConsulta` AS `IDConsulta`,`con`.`IDCliente` AS `IDCliente`,concat_ws(' ',`c`.`Nombre`,`c`.`ApellidoPaterno`,`c`.`ApellidoMaterno`) AS `Cliente`,`con`.`IDTerapeuta` AS `IDTerapeuta`,concat_ws(' ',`e`.`Nombre`,`e`.`ApellidoPaterno`,`e`.`ApellidoMaterno`) AS `Terapeuta`,`ps`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`Producto` AS `Producto`,`con`.`FechaCita` AS `FechaCita`,`con`.`IDHistorialMedico` AS `IDHistorialMedico`,`cs`.`IDConsultaStatus` AS `IDConsultaStatus`,`cs`.`Status` AS `Status`,`con`.`observaciones` AS `Observaciones` from ((((`consulta` `con` join `consultastatus` `cs` on((`cs`.`IDConsultaStatus` = `con`.`IDConsultaStatus`))) join `cliente` `c` on(((`c`.`IDCliente` = `con`.`IDCliente`) and (`c`.`Activo` = 'S')))) join `empleado` `e` on(((`e`.`IDEmpleado` = `con`.`IDTerapeuta`) and (`e`.`Activo` = 'S')))) join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `con`.`IDServicio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_empleado`
--
DROP TABLE IF EXISTS `v_empleado`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_empleado` AS select `e`.`IDEmpleado` AS `IDEmpleado`,`e`.`Nombre` AS `Nombre`,`e`.`ApellidoPaterno` AS `ApellidoPaterno`,`e`.`ApellidoMaterno` AS `ApellidoMaterno`,`e`.`Usuario` AS `Usuario`,`e`.`Contrasena` AS `Contrasena`,`e`.`IDCargo` AS `IDCargo`,`c`.`Cargo` AS `Cargo`,`e`.`Calle` AS `Calle`,`e`.`NumExterior` AS `NumExterior`,`e`.`NumInterior` AS `NumInterior`,`e`.`Colonia` AS `Colonia`,`e`.`CodigoPostal` AS `CP`,`e`.`Foto` AS `Foto`,`e`.`Email` AS `Email`,`e`.`Telefono` AS `Telefono`,`e`.`Celular` AS `Celular` from (`empleado` `e` join `cargo` `c` on(((`c`.`IDCargo` = `e`.`IDCargo`) and (`e`.`Activo` = 'S'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_empleado_deleter`
--
DROP TABLE IF EXISTS `v_empleado_deleter`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_empleado_deleter` AS select `e`.`IDEmpleado` AS `IDEmpleado`,`e`.`Nombre` AS `Nombre`,`e`.`ApellidoPaterno` AS `ApellidoPaterno`,`e`.`ApellidoMaterno` AS `ApellidoMaterno`,`e`.`Usuario` AS `Usuario`,`e`.`Contrasena` AS `Contrasena`,`e`.`IDCargo` AS `IDCargo`,`c`.`Cargo` AS `Cargo`,`e`.`Calle` AS `Calle`,`e`.`NumExterior` AS `NumExterior`,`e`.`NumInterior` AS `NumInterior`,`e`.`Colonia` AS `Colonia`,`e`.`CodigoPostal` AS `CP`,`e`.`Foto` AS `Foto`,`e`.`Email` AS `Email`,`e`.`Telefono` AS `Telefono`,`e`.`Celular` AS `Celular` from (`empleado` `e` join `cargo` `c` on(((`c`.`IDCargo` = `e`.`IDCargo`) and (`e`.`Activo` = 'N'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_existencia`
--
DROP TABLE IF EXISTS `v_existencia`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_existencia` AS select `ex`.`IDExistencia` AS `IDExistencia`,`ex`.`FechaReferencia` AS `FechaReferencia`,`ex`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`Producto` AS `Producto`,`ex`.`PrecioUnitario` AS `PrecioUnitario`,`ex`.`Cantidad` AS `Cantidad`,`ps`.`Activo` AS `Activo` from (`existencia` `ex` join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `ex`.`IDProductoServicio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_historialmedico`
--
DROP TABLE IF EXISTS `v_historialmedico`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_historialmedico` AS select `hm`.`IDHistorialMedico` AS `IDHistorialMedico`,`hm`.`IDCliente` AS `IDCliente`,concat_ws(' ',`c`.`Nombre`,`c`.`ApellidoPaterno`,`c`.`ApellidoMaterno`) AS `Cliente`,`hm`.`FechaRegistro` AS `FechaRegistro`,`hm`.`IDServicio` AS `IDServicio`,`ps`.`Producto` AS `Producto`,`hm`.`observaciones` AS `Observaciones` from ((`historialmedico` `hm` join `cliente` `c` on(((`c`.`IDCliente` = `hm`.`IDCliente`) and (`c`.`Activo` = 'S')))) join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `hm`.`IDServicio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_producto`
--
DROP TABLE IF EXISTS `v_producto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_producto` AS select `ps`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`IDProductoServicioTipo` AS `IDProductoServicioTipo`,`pst`.`ProductoServicioTipo` AS `ProductoServicioTipo`,`ps`.`Producto` AS `Producto`,`ps`.`PrecioUnitario` AS `PrecioUnitario`,`ps`.`Foto` AS `Foto`,`ps`.`Descripcion` AS `Descripcion` from (`productoservicio` `ps` join `productoserviciotipo` `pst` on((`pst`.`IDProductoServicioTipo` = `ps`.`IDProductoServicioTipo`))) where ((`ps`.`IDProductoServicioTipo` = 1) and (`ps`.`Activo` = 'S'));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_producto_deleter`
--
DROP TABLE IF EXISTS `v_producto_deleter`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_producto_deleter` AS select `ps`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`IDProductoServicioTipo` AS `IDProductoServicioTipo`,`pst`.`ProductoServicioTipo` AS `ProductoServicioTipo`,`ps`.`Producto` AS `Producto`,`ps`.`PrecioUnitario` AS `PrecioUnitario`,`ps`.`Foto` AS `Foto`,`ps`.`Descripcion` AS `Descripcion` from (`productoservicio` `ps` join `productoserviciotipo` `pst` on((`pst`.`IDProductoServicioTipo` = `ps`.`IDProductoServicioTipo`))) where ((`ps`.`IDProductoServicioTipo` = 1) and (`ps`.`Activo` = 'N'));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_proveedor`
--
DROP TABLE IF EXISTS `v_proveedor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_proveedor` AS select `p`.`IDProveedor` AS `IDProveedor`,`p`.`Nombre` AS `Nombre`,`p`.`ApellidoPaterno` AS `ApellidoPaterno`,`p`.`ApellidoMaterno` AS `ApellidoMaterno`,`p`.`RFC` AS `RFC`,`p`.`Calle` AS `Calle`,`p`.`NumExterior` AS `NumExterior`,`p`.`NumInterior` AS `NumInterior`,`p`.`Colonia` AS `Colonia`,`p`.`CodigoPostal` AS `CP`,`p`.`Email` AS `Email`,`p`.`Telefono` AS `Telefono`,`p`.`Celular` AS `Celular` from `proveedor` `p` where (`p`.`Activo` = 'S');

-- --------------------------------------------------------

--
-- Estructura para la vista `v_proveedor_deleter`
--
DROP TABLE IF EXISTS `v_proveedor_deleter`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_proveedor_deleter` AS select `p`.`IDProveedor` AS `IDProveedor`,`p`.`Nombre` AS `Nombre`,`p`.`ApellidoPaterno` AS `ApellidoPaterno`,`p`.`ApellidoMaterno` AS `ApellidoMaterno`,`p`.`RFC` AS `RFC`,`p`.`Calle` AS `Calle`,`p`.`NumExterior` AS `NumExterior`,`p`.`NumInterior` AS `NumInterior`,`p`.`Colonia` AS `Colonia`,`p`.`CodigoPostal` AS `CP`,`p`.`Email` AS `Email`,`p`.`Telefono` AS `Telefono`,`p`.`Celular` AS `Celular` from `proveedor` `p` where (`p`.`Activo` = 'N');

-- --------------------------------------------------------

--
-- Estructura para la vista `v_recepcion`
--
DROP TABLE IF EXISTS `v_recepcion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_recepcion` AS select `rec`.`IDRecepcion` AS `IDRecepcion`,`rec`.`IDMovimientoAlmacen` AS `IDMovimientoAlmacen`,`rec`.`Folio` AS `Folio`,`p`.`IDProveedor` AS `IDProveedor`,concat_ws(' ',`p`.`Nombre`,`p`.`ApellidoPaterno`,`p`.`ApellidoMaterno`) AS `Proveedor`,`e`.`IDEmpleado` AS `IDEmpleado`,concat_ws(' ',`e`.`Nombre`,`e`.`ApellidoPaterno`,`e`.`ApellidoMaterno`) AS `Empleado`,`rec`.`FechaRecepcion` AS `FechaRecepcion`,`rec`.`Total` AS `Total` from (((`recepcion` `rec` join `proveedor` `p` on(((`p`.`IDProveedor` = `rec`.`IDProveedor`) and (`p`.`Activo` = 'S')))) join `movimientoalmacen` `ma` on((`ma`.`IDMovimientoAlmacen` = `rec`.`IDMovimientoAlmacen`))) join `empleado` `e` on(((`e`.`IDEmpleado` = `ma`.`IDEmpleado`) and (`e`.`Activo` = 'S'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_recepciondetalle`
--
DROP TABLE IF EXISTS `v_recepciondetalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_recepciondetalle` AS select `recd`.`IDRecepcionDetalle` AS `IDRecepcionDetalle`,`recd`.`IDRecepcion` AS `IDRecepcion`,`recd`.`IDProducto` AS `IDProducto`,`ps`.`Producto` AS `Producto`,`recd`.`Cantidad` AS `Cantidad`,`recd`.`PrecioUnitario` AS `PrecioUnitario`,`recd`.`IVA` AS `IVA`,`recd`.`Descuento` AS `Descuento` from (`recepciondetalle` `recd` join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `recd`.`IDProducto`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_remision`
--
DROP TABLE IF EXISTS `v_remision`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_remision` AS select `rem`.`IDRemision` AS `IDRemision`,`rem`.`IDMovimientoAlmacen` AS `IDMovimientoAlmacen`,`rem`.`Folio` AS `Folio`,`c`.`IDCliente` AS `IDCliente`,concat_ws(' ',`c`.`Nombre`,`c`.`ApellidoPaterno`,`c`.`ApellidoMaterno`) AS `Cliente`,`e`.`IDEmpleado` AS `IDEmpleado`,concat_ws(' ',`e`.`Nombre`,`e`.`ApellidoPaterno`,`e`.`ApellidoMaterno`) AS `Empleado`,`rem`.`FechaRemision` AS `FechaRemision`,`rem`.`Total` AS `Total` from (((`remision` `rem` join `cliente` `c` on(((`c`.`IDCliente` = `rem`.`IDCliente`) and (`c`.`Activo` = 'S')))) join `movimientoalmacen` `ma` on((`ma`.`IDMovimientoAlmacen` = `rem`.`IDMovimientoAlmacen`))) join `empleado` `e` on(((`e`.`IDEmpleado` = `ma`.`IDEmpleado`) and (`e`.`Activo` = 'S'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_remisiondetalle`
--
DROP TABLE IF EXISTS `v_remisiondetalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_remisiondetalle` AS select `remd`.`IDRemisionDetalle` AS `IDRemisionDetalle`,`remd`.`IDRemision` AS `IDRemision`,`remd`.`IDProducto` AS `IDProducto`,`ps`.`Producto` AS `Producto`,`remd`.`Cantidad` AS `Cantidad`,`remd`.`PrecioUnitario` AS `PrecioUnitario`,`remd`.`IVA` AS `IVA`,`remd`.`Descuento` AS `Descuento` from (`remisiondetalle` `remd` join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `remd`.`IDProducto`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_servicio`
--
DROP TABLE IF EXISTS `v_servicio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_servicio` AS select `ps`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`IDProductoServicioTipo` AS `IDProductoServicioTipo`,`pst`.`ProductoServicioTipo` AS `ProductoServicioTipo`,`ps`.`Producto` AS `Producto`,`ps`.`PrecioUnitario` AS `PrecioUnitario`,`ps`.`Foto` AS `Foto`,`ps`.`Descripcion` AS `Descripcion` from (`productoservicio` `ps` join `productoserviciotipo` `pst` on((`pst`.`IDProductoServicioTipo` = `ps`.`IDProductoServicioTipo`))) where ((`ps`.`IDProductoServicioTipo` = 2) and (`ps`.`Activo` = 'S'));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_servicio_deleter`
--
DROP TABLE IF EXISTS `v_servicio_deleter`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_servicio_deleter` AS select `ps`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`IDProductoServicioTipo` AS `IDProductoServicioTipo`,`pst`.`ProductoServicioTipo` AS `ProductoServicioTipo`,`ps`.`Producto` AS `Producto`,`ps`.`PrecioUnitario` AS `PrecioUnitario`,`ps`.`Foto` AS `Foto`,`ps`.`Descripcion` AS `Descripcion` from (`productoservicio` `ps` join `productoserviciotipo` `pst` on((`pst`.`IDProductoServicioTipo` = `ps`.`IDProductoServicioTipo`))) where ((`ps`.`IDProductoServicioTipo` = 2) and (`ps`.`Activo` = 'N'));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_totalcomprado`
--
DROP TABLE IF EXISTS `v_totalcomprado`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_totalcomprado` AS select `ps`.`Producto` AS `Producto`,`recd`.`PrecioUnitario` AS `PrecioUnitario`,sum(`recd`.`Cantidad`) AS `CantidadTotalComprada`,date_format(`ma`.`MovimientoAlmacenFecha`,'%Y-%m-%d') AS `FechaCompra` from (((`productoservicio` `ps` join `recepciondetalle` `recd` on((`recd`.`IDProducto` = `ps`.`IDProductoServicio`))) join `recepcion` `rec` on((`rec`.`IDRecepcion` = `recd`.`IDRecepcion`))) join `movimientoalmacen` `ma` on((`ma`.`IDMovimientoAlmacen` = `rec`.`IDMovimientoAlmacen`))) group by `ps`.`Producto`,`recd`.`PrecioUnitario`,`FechaCompra`;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_totalvendido`
--
DROP TABLE IF EXISTS `v_totalvendido`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_totalvendido` AS select `ps`.`Producto` AS `Producto`,`remd`.`PrecioUnitario` AS `PrecioUnitario`,sum(`remd`.`Cantidad`) AS `CantidadTotalVendida`,date_format(`ma`.`MovimientoAlmacenFecha`,'%Y-%m-%d') AS `FechaVenta` from (((`productoservicio` `ps` join `remisiondetalle` `remd` on((`remd`.`IDProducto` = `ps`.`IDProductoServicio`))) join `remision` `rem` on((`rem`.`IDRemision` = `remd`.`IDRemision`))) join `movimientoalmacen` `ma` on((`ma`.`IDMovimientoAlmacen` = `rem`.`IDMovimientoAlmacen`))) group by `ps`.`Producto`,`remd`.`PrecioUnitario`,`FechaVenta`;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `AguaAlDia`
--
ALTER TABLE `AguaAlDia`
 ADD PRIMARY KEY (`IDAguaAlDia`,`IDHistorialMedico`), ADD UNIQUE KEY `IDAguaAlDia` (`IDAguaAlDia`), ADD KEY `FKAguaAlDia625443` (`IDHistorialMedico`);

--
-- Indices de la tabla `AjusteEntrada`
--
ALTER TABLE `AjusteEntrada`
 ADD PRIMARY KEY (`IDAjusteEntrada`,`IDMovimientoAlmacen`), ADD UNIQUE KEY `IDAjusteEntrada` (`IDAjusteEntrada`), ADD UNIQUE KEY `Folio` (`Folio`), ADD KEY `FKAjusteEntr817793` (`IDMovimientoAlmacen`), ADD KEY `FKAjusteEntr762431` (`IDCliente`), ADD KEY `FKAjusteEntr133801` (`IDAjusteEntradaTipo`);

--
-- Indices de la tabla `AjusteEntradaDetalle`
--
ALTER TABLE `AjusteEntradaDetalle`
 ADD PRIMARY KEY (`IDAjusteEntradaDetalle`,`IDAjusteEntrada`), ADD UNIQUE KEY `IDAjusteEntradaDetalle` (`IDAjusteEntradaDetalle`), ADD KEY `FKAjusteEntr965676` (`IDAjusteEntrada`), ADD KEY `FKAjusteEntr951580` (`IDProductoServicio`);

--
-- Indices de la tabla `AjusteEntradaTipo`
--
ALTER TABLE `AjusteEntradaTipo`
 ADD PRIMARY KEY (`IDAjusteEntradaTipo`), ADD UNIQUE KEY `IDAjusteEntradaTipo` (`IDAjusteEntradaTipo`);

--
-- Indices de la tabla `AjusteSalida`
--
ALTER TABLE `AjusteSalida`
 ADD PRIMARY KEY (`IDAjusteSalida`,`IDMovimientoAlmacen`), ADD UNIQUE KEY `IDAjusteSalida` (`IDAjusteSalida`), ADD UNIQUE KEY `Folio` (`Folio`), ADD KEY `FKAjusteSali232744` (`IDMovimientoAlmacen`), ADD KEY `FKAjusteSali566873` (`IDProveedor`), ADD KEY `FKAjusteSali329927` (`IDAjusteSalidaTipo`);

--
-- Indices de la tabla `AjusteSalidaDetalle`
--
ALTER TABLE `AjusteSalidaDetalle`
 ADD PRIMARY KEY (`IDAjusteSalidaDetalle`,`IDAjusteSalida`), ADD UNIQUE KEY `IDAjusteSalidaDetalle` (`IDAjusteSalidaDetalle`), ADD KEY `FKAjusteSali199966` (`IDAjusteSalida`), ADD KEY `FKAjusteSali116948` (`IDProductoServicio`);

--
-- Indices de la tabla `AjusteSalidaTipo`
--
ALTER TABLE `AjusteSalidaTipo`
 ADD PRIMARY KEY (`IDAjusteSalidaTipo`), ADD UNIQUE KEY `IDAjusteSalidaTipo` (`IDAjusteSalidaTipo`);

--
-- Indices de la tabla `Alimentacion`
--
ALTER TABLE `Alimentacion`
 ADD PRIMARY KEY (`IDAlimentacion`,`IDHistorialMedico`), ADD UNIQUE KEY `IDAlimentacion` (`IDAlimentacion`), ADD KEY `FKAlimentaci962672` (`IDHistorialMedico`);

--
-- Indices de la tabla `Cargo`
--
ALTER TABLE `Cargo`
 ADD PRIMARY KEY (`IDCargo`), ADD UNIQUE KEY `IDCargo` (`IDCargo`);

--
-- Indices de la tabla `Cliente`
--
ALTER TABLE `Cliente`
 ADD PRIMARY KEY (`IDCliente`), ADD UNIQUE KEY `IDCliente` (`IDCliente`);

--
-- Indices de la tabla `Consulta`
--
ALTER TABLE `Consulta`
 ADD PRIMARY KEY (`IDConsulta`), ADD UNIQUE KEY `IDConsulta` (`IDConsulta`), ADD KEY `FKConsulta393400` (`IDConsultaStatus`), ADD KEY `FKConsulta287998` (`IDCliente`), ADD KEY `FKConsulta768151` (`IDTerapeuta`), ADD KEY `FKConsulta744754` (`IDHistorialMedico`);

--
-- Indices de la tabla `ConsultaStatus`
--
ALTER TABLE `ConsultaStatus`
 ADD PRIMARY KEY (`IDConsultaStatus`), ADD UNIQUE KEY `IDConsultaStatus` (`IDConsultaStatus`);

--
-- Indices de la tabla `Empleado`
--
ALTER TABLE `Empleado`
 ADD PRIMARY KEY (`IDEmpleado`), ADD UNIQUE KEY `IDEmpleado` (`IDEmpleado`), ADD UNIQUE KEY `Usuario` (`Usuario`), ADD KEY `FKEmpleado545786` (`IDCargo`), ADD KEY `IDEX_Usuario` (`Usuario`) USING BTREE;

--
-- Indices de la tabla `EmpleadoSueldo`
--
ALTER TABLE `EmpleadoSueldo`
 ADD PRIMARY KEY (`IDEmpleadoSueldo`), ADD KEY `IDEmpleado` (`IDEmpleado`);

--
-- Indices de la tabla `Exfoliacion`
--
ALTER TABLE `Exfoliacion`
 ADD PRIMARY KEY (`IDExfoliacion`,`IDHistorialMedico`), ADD UNIQUE KEY `IDExfoliacion` (`IDExfoliacion`), ADD KEY `FKExfoliacio997845` (`IDHistorialMedico`);

--
-- Indices de la tabla `Existencia`
--
ALTER TABLE `Existencia`
 ADD PRIMARY KEY (`IDExistencia`,`FechaReferencia`), ADD UNIQUE KEY `IDExistencia` (`IDExistencia`), ADD KEY `FKExistencia174224` (`IDProductoServicio`);

--
-- Indices de la tabla `ExploracionFinal`
--
ALTER TABLE `ExploracionFinal`
 ADD PRIMARY KEY (`IDExploracionFinal`,`IDHistorialMedico`), ADD UNIQUE KEY `IDExploracionFinal` (`IDExploracionFinal`), ADD KEY `IDHistorialMedico` (`IDHistorialMedico`);

--
-- Indices de la tabla `ExploracionInicial`
--
ALTER TABLE `ExploracionInicial`
 ADD PRIMARY KEY (`IDExploracionInicial`,`IDHistorialMedico`), ADD UNIQUE KEY `IDExploracionInicial` (`IDExploracionInicial`), ADD KEY `IDHistorialMedico` (`IDHistorialMedico`);

--
-- Indices de la tabla `FichaClinica`
--
ALTER TABLE `FichaClinica`
 ADD PRIMARY KEY (`IDFichaClinica`,`IDHistorialMedico`), ADD UNIQUE KEY `IDFichaClinica` (`IDFichaClinica`), ADD KEY `FKFichaClini138377` (`IDHistorialMedico`);

--
-- Indices de la tabla `Habito`
--
ALTER TABLE `Habito`
 ADD PRIMARY KEY (`IDHabito`,`IDHistorialMedico`), ADD UNIQUE KEY `IDHabito` (`IDHabito`), ADD KEY `FKHabito806866` (`IDHistorialMedico`);

--
-- Indices de la tabla `HistorialMedico`
--
ALTER TABLE `HistorialMedico`
 ADD PRIMARY KEY (`IDHistorialMedico`,`IDCliente`), ADD UNIQUE KEY `IDHistorialMedico` (`IDHistorialMedico`), ADD KEY `FKHistorialM959828` (`IDServicio`), ADD KEY `FKHistorialM865695` (`IDCliente`);

--
-- Indices de la tabla `MovimientoAlmacen`
--
ALTER TABLE `MovimientoAlmacen`
 ADD PRIMARY KEY (`IDMovimientoAlmacen`), ADD UNIQUE KEY `IDMovimientoAlmacen` (`IDMovimientoAlmacen`), ADD KEY `FKMovimiento137480` (`IDMovimientoAlmacenTipo`), ADD KEY `FKMovimiento729160` (`IDEmpleado`);

--
-- Indices de la tabla `MovimientoAlmacenTipo`
--
ALTER TABLE `MovimientoAlmacenTipo`
 ADD PRIMARY KEY (`IDMovimientoAlmacenTipo`), ADD UNIQUE KEY `IDMovimientoAlmacenTipo` (`IDMovimientoAlmacenTipo`);

--
-- Indices de la tabla `Padecimiento`
--
ALTER TABLE `Padecimiento`
 ADD PRIMARY KEY (`IDPadecimiento`,`IDHistorialMedico`), ADD UNIQUE KEY `IDPadecimiento` (`IDPadecimiento`), ADD KEY `FKPadecimien990892` (`IDHistorialMedico`);

--
-- Indices de la tabla `Piel`
--
ALTER TABLE `Piel`
 ADD PRIMARY KEY (`IDPiel`,`IDHistorialMedico`), ADD UNIQUE KEY `IDPiel` (`IDPiel`), ADD KEY `FKPiel612399` (`IDHistorialMedico`);

--
-- Indices de la tabla `ProductoServicio`
--
ALTER TABLE `ProductoServicio`
 ADD PRIMARY KEY (`IDProductoServicio`), ADD UNIQUE KEY `IDProductoServicio` (`IDProductoServicio`), ADD KEY `FKProductoSe737139` (`IDProductoServicioTipo`);

--
-- Indices de la tabla `ProductoServicioTipo`
--
ALTER TABLE `ProductoServicioTipo`
 ADD PRIMARY KEY (`IDProductoServicioTipo`), ADD UNIQUE KEY `IDProductoServicioTipo` (`IDProductoServicioTipo`);

--
-- Indices de la tabla `Proveedor`
--
ALTER TABLE `Proveedor`
 ADD PRIMARY KEY (`IDProveedor`), ADD UNIQUE KEY `IDProveedor` (`IDProveedor`), ADD UNIQUE KEY `RFC` (`RFC`);

--
-- Indices de la tabla `Recepcion`
--
ALTER TABLE `Recepcion`
 ADD PRIMARY KEY (`IDRecepcion`,`IDMovimientoAlmacen`), ADD UNIQUE KEY `IDRecepcion` (`IDRecepcion`), ADD UNIQUE KEY `Folio` (`Folio`), ADD KEY `FKRecepcion658770` (`IDProveedor`), ADD KEY `FKRecepcion859152` (`IDMovimientoAlmacen`);

--
-- Indices de la tabla `RecepcionDetalle`
--
ALTER TABLE `RecepcionDetalle`
 ADD PRIMARY KEY (`IDRecepcionDetalle`,`IDRecepcion`), ADD UNIQUE KEY `IDRecepcionDetalle` (`IDRecepcionDetalle`), ADD KEY `FKRecepcionD531606` (`IDProducto`), ADD KEY `FKRecepcionD845984` (`IDRecepcion`);

--
-- Indices de la tabla `Remision`
--
ALTER TABLE `Remision`
 ADD PRIMARY KEY (`IDRemision`,`IDMovimientoAlmacen`), ADD UNIQUE KEY `IDRemision` (`IDRemision`), ADD UNIQUE KEY `Folio` (`Folio`), ADD KEY `FKRemision665472` (`IDMovimientoAlmacen`), ADD KEY `FKRemision610110` (`IDCliente`);

--
-- Indices de la tabla `RemisionDetalle`
--
ALTER TABLE `RemisionDetalle`
 ADD PRIMARY KEY (`IDRemisionDetalle`,`IDRemision`), ADD UNIQUE KEY `IDRemisionDetalle` (`IDRemisionDetalle`), ADD KEY `FKRemisionDe671804` (`IDRemision`), ADD KEY `FKRemisionDe425762` (`IDProducto`);

--
-- Indices de la tabla `TipoCelulitis`
--
ALTER TABLE `TipoCelulitis`
 ADD PRIMARY KEY (`IDTipoCelulitis`,`IDHistorialMedico`), ADD UNIQUE KEY `IDTipoCelulitis` (`IDTipoCelulitis`), ADD KEY `FKTipoCeluli51692` (`IDHistorialMedico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `AguaAlDia`
--
ALTER TABLE `AguaAlDia`
MODIFY `IDAguaAlDia` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `AjusteEntrada`
--
ALTER TABLE `AjusteEntrada`
MODIFY `IDAjusteEntrada` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `AjusteEntradaDetalle`
--
ALTER TABLE `AjusteEntradaDetalle`
MODIFY `IDAjusteEntradaDetalle` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `AjusteEntradaTipo`
--
ALTER TABLE `AjusteEntradaTipo`
MODIFY `IDAjusteEntradaTipo` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `AjusteSalida`
--
ALTER TABLE `AjusteSalida`
MODIFY `IDAjusteSalida` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `AjusteSalidaDetalle`
--
ALTER TABLE `AjusteSalidaDetalle`
MODIFY `IDAjusteSalidaDetalle` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `AjusteSalidaTipo`
--
ALTER TABLE `AjusteSalidaTipo`
MODIFY `IDAjusteSalidaTipo` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Alimentacion`
--
ALTER TABLE `Alimentacion`
MODIFY `IDAlimentacion` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `Cargo`
--
ALTER TABLE `Cargo`
MODIFY `IDCargo` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `Cliente`
--
ALTER TABLE `Cliente`
MODIFY `IDCliente` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Consulta`
--
ALTER TABLE `Consulta`
MODIFY `IDConsulta` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `ConsultaStatus`
--
ALTER TABLE `ConsultaStatus`
MODIFY `IDConsultaStatus` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `Empleado`
--
ALTER TABLE `Empleado`
MODIFY `IDEmpleado` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `EmpleadoSueldo`
--
ALTER TABLE `EmpleadoSueldo`
MODIFY `IDEmpleadoSueldo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Exfoliacion`
--
ALTER TABLE `Exfoliacion`
MODIFY `IDExfoliacion` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `Existencia`
--
ALTER TABLE `Existencia`
MODIFY `IDExistencia` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ExploracionFinal`
--
ALTER TABLE `ExploracionFinal`
MODIFY `IDExploracionFinal` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `ExploracionInicial`
--
ALTER TABLE `ExploracionInicial`
MODIFY `IDExploracionInicial` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `FichaClinica`
--
ALTER TABLE `FichaClinica`
MODIFY `IDFichaClinica` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `Habito`
--
ALTER TABLE `Habito`
MODIFY `IDHabito` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `HistorialMedico`
--
ALTER TABLE `HistorialMedico`
MODIFY `IDHistorialMedico` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `MovimientoAlmacen`
--
ALTER TABLE `MovimientoAlmacen`
MODIFY `IDMovimientoAlmacen` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT de la tabla `MovimientoAlmacenTipo`
--
ALTER TABLE `MovimientoAlmacenTipo`
MODIFY `IDMovimientoAlmacenTipo` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `Padecimiento`
--
ALTER TABLE `Padecimiento`
MODIFY `IDPadecimiento` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `Piel`
--
ALTER TABLE `Piel`
MODIFY `IDPiel` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `ProductoServicio`
--
ALTER TABLE `ProductoServicio`
MODIFY `IDProductoServicio` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `ProductoServicioTipo`
--
ALTER TABLE `ProductoServicioTipo`
MODIFY `IDProductoServicioTipo` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `Proveedor`
--
ALTER TABLE `Proveedor`
MODIFY `IDProveedor` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Recepcion`
--
ALTER TABLE `Recepcion`
MODIFY `IDRecepcion` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `RecepcionDetalle`
--
ALTER TABLE `RecepcionDetalle`
MODIFY `IDRecepcionDetalle` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `Remision`
--
ALTER TABLE `Remision`
MODIFY `IDRemision` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `RemisionDetalle`
--
ALTER TABLE `RemisionDetalle`
MODIFY `IDRemisionDetalle` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `TipoCelulitis`
--
ALTER TABLE `TipoCelulitis`
MODIFY `IDTipoCelulitis` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `AguaAlDia`
--
ALTER TABLE `AguaAlDia`
ADD CONSTRAINT `FKAguaAlDia625443` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `AjusteEntrada`
--
ALTER TABLE `AjusteEntrada`
ADD CONSTRAINT `FKAjusteEntr133801` FOREIGN KEY (`IDAjusteEntradaTipo`) REFERENCES `ajusteentradatipo` (`IDAjusteEntradaTipo`),
ADD CONSTRAINT `FKAjusteEntr762431` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`),
ADD CONSTRAINT `FKAjusteEntr817793` FOREIGN KEY (`IDMovimientoAlmacen`) REFERENCES `movimientoalmacen` (`IDMovimientoAlmacen`);

--
-- Filtros para la tabla `AjusteEntradaDetalle`
--
ALTER TABLE `AjusteEntradaDetalle`
ADD CONSTRAINT `FKAjusteEntr951580` FOREIGN KEY (`IDProductoServicio`) REFERENCES `productoservicio` (`IDProductoServicio`),
ADD CONSTRAINT `FKAjusteEntr965676` FOREIGN KEY (`IDAjusteEntrada`) REFERENCES `ajusteentrada` (`IDAjusteEntrada`);

--
-- Filtros para la tabla `AjusteSalida`
--
ALTER TABLE `AjusteSalida`
ADD CONSTRAINT `FKAjusteSali232744` FOREIGN KEY (`IDMovimientoAlmacen`) REFERENCES `movimientoalmacen` (`IDMovimientoAlmacen`),
ADD CONSTRAINT `FKAjusteSali329927` FOREIGN KEY (`IDAjusteSalidaTipo`) REFERENCES `ajustesalidatipo` (`IDAjusteSalidaTipo`),
ADD CONSTRAINT `FKAjusteSali566873` FOREIGN KEY (`IDProveedor`) REFERENCES `proveedor` (`IDProveedor`);

--
-- Filtros para la tabla `AjusteSalidaDetalle`
--
ALTER TABLE `AjusteSalidaDetalle`
ADD CONSTRAINT `FKAjusteSali116948` FOREIGN KEY (`IDProductoServicio`) REFERENCES `productoservicio` (`IDProductoServicio`),
ADD CONSTRAINT `FKAjusteSali199966` FOREIGN KEY (`IDAjusteSalida`) REFERENCES `ajustesalida` (`IDAjusteSalida`);

--
-- Filtros para la tabla `Alimentacion`
--
ALTER TABLE `Alimentacion`
ADD CONSTRAINT `FKAlimentaci962672` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `Consulta`
--
ALTER TABLE `Consulta`
ADD CONSTRAINT `FKConsulta287998` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`),
ADD CONSTRAINT `FKConsulta393400` FOREIGN KEY (`IDConsultaStatus`) REFERENCES `consultastatus` (`IDConsultaStatus`),
ADD CONSTRAINT `FKConsulta768151` FOREIGN KEY (`IDTerapeuta`) REFERENCES `empleado` (`IDEmpleado`);

--
-- Filtros para la tabla `Empleado`
--
ALTER TABLE `Empleado`
ADD CONSTRAINT `FKEmpleado545786` FOREIGN KEY (`IDCargo`) REFERENCES `cargo` (`IDCargo`);

--
-- Filtros para la tabla `EmpleadoSueldo`
--
ALTER TABLE `EmpleadoSueldo`
ADD CONSTRAINT `EmpleadoSueldo_ibfk_1` FOREIGN KEY (`IDEmpleado`) REFERENCES `empleado` (`IDEmpleado`);

--
-- Filtros para la tabla `Exfoliacion`
--
ALTER TABLE `Exfoliacion`
ADD CONSTRAINT `FKExfoliacio997845` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `Existencia`
--
ALTER TABLE `Existencia`
ADD CONSTRAINT `FKExistencia174224` FOREIGN KEY (`IDProductoServicio`) REFERENCES `productoservicio` (`IDProductoServicio`);

--
-- Filtros para la tabla `ExploracionFinal`
--
ALTER TABLE `ExploracionFinal`
ADD CONSTRAINT `ExploracionFinal_ibfk_1` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `ExploracionInicial`
--
ALTER TABLE `ExploracionInicial`
ADD CONSTRAINT `ExploracionInicial_ibfk_1` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `FichaClinica`
--
ALTER TABLE `FichaClinica`
ADD CONSTRAINT `FKFichaClini138377` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `Habito`
--
ALTER TABLE `Habito`
ADD CONSTRAINT `FKHabito806866` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `HistorialMedico`
--
ALTER TABLE `HistorialMedico`
ADD CONSTRAINT `FKHistorialM865695` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`),
ADD CONSTRAINT `FKHistorialM959828` FOREIGN KEY (`IDServicio`) REFERENCES `productoservicio` (`IDProductoServicio`);

--
-- Filtros para la tabla `MovimientoAlmacen`
--
ALTER TABLE `MovimientoAlmacen`
ADD CONSTRAINT `FKMovimiento137480` FOREIGN KEY (`IDMovimientoAlmacenTipo`) REFERENCES `movimientoalmacentipo` (`IDMovimientoAlmacenTipo`),
ADD CONSTRAINT `FKMovimiento729160` FOREIGN KEY (`IDEmpleado`) REFERENCES `empleado` (`IDEmpleado`);

--
-- Filtros para la tabla `Padecimiento`
--
ALTER TABLE `Padecimiento`
ADD CONSTRAINT `FKPadecimien990892` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `Piel`
--
ALTER TABLE `Piel`
ADD CONSTRAINT `FKPiel612399` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `ProductoServicio`
--
ALTER TABLE `ProductoServicio`
ADD CONSTRAINT `FKProductoSe737139` FOREIGN KEY (`IDProductoServicioTipo`) REFERENCES `productoserviciotipo` (`IDProductoServicioTipo`);

--
-- Filtros para la tabla `Recepcion`
--
ALTER TABLE `Recepcion`
ADD CONSTRAINT `FKRecepcion658770` FOREIGN KEY (`IDProveedor`) REFERENCES `proveedor` (`IDProveedor`),
ADD CONSTRAINT `FKRecepcion859152` FOREIGN KEY (`IDMovimientoAlmacen`) REFERENCES `movimientoalmacen` (`IDMovimientoAlmacen`);

--
-- Filtros para la tabla `RecepcionDetalle`
--
ALTER TABLE `RecepcionDetalle`
ADD CONSTRAINT `FKRecepcionD531606` FOREIGN KEY (`IDProducto`) REFERENCES `productoservicio` (`IDProductoServicio`),
ADD CONSTRAINT `FKRecepcionD845984` FOREIGN KEY (`IDRecepcion`) REFERENCES `recepcion` (`IDRecepcion`);

--
-- Filtros para la tabla `Remision`
--
ALTER TABLE `Remision`
ADD CONSTRAINT `FKRemision610110` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`),
ADD CONSTRAINT `FKRemision665472` FOREIGN KEY (`IDMovimientoAlmacen`) REFERENCES `movimientoalmacen` (`IDMovimientoAlmacen`);

--
-- Filtros para la tabla `RemisionDetalle`
--
ALTER TABLE `RemisionDetalle`
ADD CONSTRAINT `FKRemisionDe425762` FOREIGN KEY (`IDProducto`) REFERENCES `productoservicio` (`IDProductoServicio`),
ADD CONSTRAINT `FKRemisionDe671804` FOREIGN KEY (`IDRemision`) REFERENCES `remision` (`IDRemision`);

--
-- Filtros para la tabla `TipoCelulitis`
--
ALTER TABLE `TipoCelulitis`
ADD CONSTRAINT `FKTipoCeluli51692` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
