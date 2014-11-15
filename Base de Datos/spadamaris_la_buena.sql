-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2014 a las 23:34:44
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
DROP PROCEDURE IF EXISTS `activarCliente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `activarCliente`(IN ID INT)
BEGIN
	UPDATE Cliente SET Activo="S" WHERE IDCliente=ID AND Activo = 'N';
END$$

DROP PROCEDURE IF EXISTS `activarEmpleado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `activarEmpleado`(IN ID INT)
BEGIN
	UPDATE Empleado SET Activo="S" WHERE IDEmpleado=ID AND Activo = 'N';
END$$

DROP PROCEDURE IF EXISTS `activarProductoServicio`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `activarProductoServicio`(IN ID INT)
BEGIN
	UPDATE ProductoServicio SET Activo="S" WHERE IDProductoServicio=ID AND Activo = 'N';
END$$

DROP PROCEDURE IF EXISTS `activarProveedor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `activarProveedor`(IN ID INT)
BEGIN
	UPDATE Proveedor SET Activo="S" WHERE IDProveedor=ID AND Activo = 'N';
END$$

DROP PROCEDURE IF EXISTS `desactivarCliente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `desactivarCliente`(IN ID INT)
BEGIN
	UPDATE Cliente SET Activo="N" WHERE IDCliente=ID AND Activo = 'S';
END$$

DROP PROCEDURE IF EXISTS `desactivarEmpleado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `desactivarEmpleado`(IN ID INT)
BEGIN
	UPDATE Empleado SET Activo="N" WHERE IDEmpleado=ID AND Activo = 'S';
END$$

DROP PROCEDURE IF EXISTS `desactivarProductoServicio`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `desactivarProductoServicio`(IN ID INT)
BEGIN
	UPDATE ProductoServicio SET Activo="N" WHERE IDProductoServicio=ID AND Activo = 'S';
END$$

DROP PROCEDURE IF EXISTS `desactivarProveedor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `desactivarProveedor`(IN ID INT)
BEGIN
	UPDATE Proveedor SET Activo="N" WHERE IDProveedor=ID AND Activo = 'S';
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aguaaldia`
--

DROP TABLE IF EXISTS `aguaaldia`;
CREATE TABLE IF NOT EXISTS `aguaaldia` (
`IDAguaAlDia` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Poca` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Regular` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Mucha` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajusteentrada`
--

DROP TABLE IF EXISTS `ajusteentrada`;
CREATE TABLE IF NOT EXISTS `ajusteentrada` (
`IDAjusteEntrada` int(10) NOT NULL,
  `IDMovimientoAlmacen` int(10) NOT NULL,
  `IDAjusteEntradaTipo` int(10) NOT NULL,
  `IDCliente` int(10) DEFAULT NULL,
  `Folio` int(10) NOT NULL,
  `Observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajusteentradadetalle`
--

DROP TABLE IF EXISTS `ajusteentradadetalle`;
CREATE TABLE IF NOT EXISTS `ajusteentradadetalle` (
`IDAjusteEntradaDetalle` int(10) NOT NULL,
  `IDAjusteEntrada` int(10) NOT NULL,
  `IDProductoServicio` int(10) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajusteentradatipo`
--

DROP TABLE IF EXISTS `ajusteentradatipo`;
CREATE TABLE IF NOT EXISTS `ajusteentradatipo` (
`IDAjusteEntradaTipo` int(10) NOT NULL,
  `Tipo` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ExclusivoSistema` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `ajusteentradatipo`
--

INSERT INTO `ajusteentradatipo` (`IDAjusteEntradaTipo`, `Tipo`, `ExclusivoSistema`, `Descripcion`) VALUES
(1, 'Entrada por Devolución', 'N', 'Mercancía que nos regresa un Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajustesalida`
--

DROP TABLE IF EXISTS `ajustesalida`;
CREATE TABLE IF NOT EXISTS `ajustesalida` (
`IDAjusteSalida` int(10) NOT NULL,
  `IDMovimientoAlmacen` int(10) NOT NULL,
  `IDAjusteSalidaTipo` int(10) NOT NULL,
  `IDProveedor` int(10) DEFAULT NULL,
  `Folio` int(10) NOT NULL,
  `Observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajustesalidadetalle`
--

DROP TABLE IF EXISTS `ajustesalidadetalle`;
CREATE TABLE IF NOT EXISTS `ajustesalidadetalle` (
`IDAjusteSalidaDetalle` int(10) NOT NULL,
  `IDAjusteSalida` int(10) NOT NULL,
  `IDProductoServicio` int(10) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajustesalidatipo`
--

DROP TABLE IF EXISTS `ajustesalidatipo`;
CREATE TABLE IF NOT EXISTS `ajustesalidatipo` (
`IDAjusteSalidaTipo` int(10) NOT NULL,
  `Tipo` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ExclusivoSistema` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `ajustesalidatipo`
--

INSERT INTO `ajustesalidatipo` (`IDAjusteSalidaTipo`, `Tipo`, `ExclusivoSistema`, `Descripcion`) VALUES
(1, 'Salida por Devolución', 'N', 'Mercancía que se regresa al Proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentacion`
--

DROP TABLE IF EXISTS `alimentacion`;
CREATE TABLE IF NOT EXISTS `alimentacion` (
`IDAlimentacion` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Buena` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Regular` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Mala` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

DROP TABLE IF EXISTS `cargo`;
CREATE TABLE IF NOT EXISTS `cargo` (
`IDCargo` int(10) NOT NULL,
  `Cargo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`IDCargo`, `Cargo`, `Descripcion`) VALUES
(1, 'Administrador', 'Encargado de las Operaciones Del Sistema'),
(2, 'Terapeuta', 'Encargado de Atender a Los Pacientes en Las Consultas y Autorizado para Vender Producto'),
(3, 'Empleado', 'es el encargado de atender a los cliente y proveedores en las compras y ventas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`IDCliente`, `Nombre`, `ApellidoPaterno`, `ApellidoMaterno`, `Calle`, `NumExterior`, `NumInterior`, `Colonia`, `CodigoPostal`, `Email`, `Telefono`, `Celular`, `Activo`) VALUES
(1, 'ramon', 'lozano', 'franco', 'obolo', '3973', NULL, 'lagos de oriente', '44790', NULL, NULL, NULL, 'S'),
(2, 'abima', 'velazquez', 'perez', 'bla bla', '278', NULL, 'bla bla bla ', '12345', NULL, NULL, NULL, 'S'),
(3, 'ramon', 'perez', 'placencia', 'obolo', '3973', NULL, 'lalalalal', '48895', 'gerardo@hotmail.com', NULL, NULL, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

DROP TABLE IF EXISTS `consulta`;
CREATE TABLE IF NOT EXISTS `consulta` (
`IDConsulta` int(10) NOT NULL,
  `IDCliente` int(10) NOT NULL,
  `IDTerapeuta` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `FechaCita` date NOT NULL,
  `IDConsultaStatus` int(10) NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultastatus`
--

DROP TABLE IF EXISTS `consultastatus`;
CREATE TABLE IF NOT EXISTS `consultastatus` (
`IDConsultaStatus` int(10) NOT NULL,
  `Status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `consultastatus`
--

INSERT INTO `consultastatus` (`IDConsultaStatus`, `Status`, `Descripcion`) VALUES
(1, 'Cliente Iniciado', 'Cliente que empezo su terapia'),
(2, 'Cliente Finalizado', 'Cliente que termino su terapia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

DROP TABLE IF EXISTS `empleado`;
CREATE TABLE IF NOT EXISTS `empleado` (
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
  `Email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefono` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Celular` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Activo` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'S'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`IDEmpleado`, `Nombre`, `ApellidoPaterno`, `ApellidoMaterno`, `Usuario`, `Contrasena`, `IDCargo`, `Calle`, `NumExterior`, `NumInterior`, `Colonia`, `CodigoPostal`, `Foto`, `Email`, `Telefono`, `Celular`, `Activo`) VALUES
(1, 'ramon ', 'lozano ', 'franco ', 'rmn528', '1234', 1, 'obolo', '3973', '', 'lagos de oriente', '44790', '', '', '', '', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleadosueldo`
--

DROP TABLE IF EXISTS `empleadosueldo`;
CREATE TABLE IF NOT EXISTS `empleadosueldo` (
`IDSueldoEmpleado` int(11) NOT NULL,
  `IDEmpleado` int(11) NOT NULL,
  `FechaSueldo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Sueldo` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exfoliacion`
--

DROP TABLE IF EXISTS `exfoliacion`;
CREATE TABLE IF NOT EXISTS `exfoliacion` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencia`
--

DROP TABLE IF EXISTS `existencia`;
CREATE TABLE IF NOT EXISTS `existencia` (
`IDExistencia` int(10) NOT NULL,
  `FechaReferencia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IDProductoServicio` int(10) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exploracionfinal`
--

DROP TABLE IF EXISTS `exploracionfinal`;
CREATE TABLE IF NOT EXISTS `exploracionfinal` (
`IDExploracionFinal` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `PesoFinal` decimal(10,3) DEFAULT NULL,
  `BustoFinal` decimal(10,3) DEFAULT NULL,
  `DiafragmaFinal` decimal(10,3) DEFAULT NULL,
  `BrazoFinal` decimal(10,3) DEFAULT NULL,
  `CinturaFinal` decimal(10,3) DEFAULT NULL,
  `AbdomenFInal` decimal(10,3) DEFAULT NULL,
  `CaderaFinal` decimal(10,3) DEFAULT NULL,
  `MusloFinal` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exploracioninicial`
--

DROP TABLE IF EXISTS `exploracioninicial`;
CREATE TABLE IF NOT EXISTS `exploracioninicial` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichaclinica`
--

DROP TABLE IF EXISTS `fichaclinica`;
CREATE TABLE IF NOT EXISTS `fichaclinica` (
`IDFichaClinica` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `MotivoConsulta` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `TiempoProblema` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `RelacionaCon` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `TratamientoAnterior` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `MetodosProbados` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `ResultadosAnteriores` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habito`
--

DROP TABLE IF EXISTS `habito`;
CREATE TABLE IF NOT EXISTS `habito` (
`IDHabito` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Fumar` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ejercicio` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UsarFaja` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sueño` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TomaSol` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Bloqueador` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Hidroquinona` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialmedico`
--

DROP TABLE IF EXISTS `historialmedico`;
CREATE TABLE IF NOT EXISTS `historialmedico` (
`IDHistorialMedico` int(10) NOT NULL,
  `IDCliente` int(10) NOT NULL,
  `FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IDServicio` int(10) NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientoalmacen`
--

DROP TABLE IF EXISTS `movimientoalmacen`;
CREATE TABLE IF NOT EXISTS `movimientoalmacen` (
`IDMovimientoAlmacen` int(10) NOT NULL,
  `IDMovimientoAlmacenTipo` int(10) NOT NULL,
  `MovimientoAlmacenFecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IDEmpleado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientoalmacentipo`
--

DROP TABLE IF EXISTS `movimientoalmacentipo`;
CREATE TABLE IF NOT EXISTS `movimientoalmacentipo` (
`IDMovimientoAlmacenTipo` int(10) NOT NULL,
  `TipoMovimientoAlmacen` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `EntradaSalida` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `movimientoalmacentipo`
--

INSERT INTO `movimientoalmacentipo` (`IDMovimientoAlmacenTipo`, `TipoMovimientoAlmacen`, `EntradaSalida`, `Descripcion`) VALUES
(1, 'Ajuste de Entrada', 'E', 'Entrada de Mercancía al Almacén'),
(2, 'Ajuste de Salida', 'S', 'Salida de Mercancía del Almacén'),
(3, 'Remision', 'S', 'Venta de Mercancía'),
(4, 'Recepcion', 'E', 'Compra de Mercancía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `padecimiento`
--

DROP TABLE IF EXISTS `padecimiento`;
CREATE TABLE IF NOT EXISTS `padecimiento` (
`IDPadecimiento` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Diabetes` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Obesisdad` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Depresion` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Estres` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sobrepeso` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Estreñimiento` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Colitis` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RetencionLiquidos` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TranstornosMesntruales` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CuidadosCorporales` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Embarazo` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piel`
--

DROP TABLE IF EXISTS `piel`;
CREATE TABLE IF NOT EXISTS `piel` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productoservicio`
--

DROP TABLE IF EXISTS `productoservicio`;
CREATE TABLE IF NOT EXISTS `productoservicio` (
`IDProductoServicio` int(10) NOT NULL,
  `IDProductoServicioTipo` int(10) NOT NULL,
  `Producto` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `Foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Activo` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productoserviciotipo`
--

DROP TABLE IF EXISTS `productoserviciotipo`;
CREATE TABLE IF NOT EXISTS `productoserviciotipo` (
`IDProductoServicioTipo` int(10) NOT NULL,
  `ProductoServicioTipo` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `productoserviciotipo`
--

INSERT INTO `productoserviciotipo` (`IDProductoServicioTipo`, `ProductoServicioTipo`, `Descripcion`) VALUES
(1, 'Producto', 'Mercancía que ofrecemos al cliente'),
(2, 'Servicio', 'Todo aquel trabajo realizado, por ejemplo: las terapias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE IF NOT EXISTS `proveedor` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcion`
--

DROP TABLE IF EXISTS `recepcion`;
CREATE TABLE IF NOT EXISTS `recepcion` (
`IDRecepcion` int(10) NOT NULL,
  `IDMovimientoAlmacen` int(10) NOT NULL,
  `IDProveedor` int(10) NOT NULL,
  `Folio` int(10) NOT NULL,
  `FechaRecepcion` date NOT NULL,
  `Total` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepciondetalle`
--

DROP TABLE IF EXISTS `recepciondetalle`;
CREATE TABLE IF NOT EXISTS `recepciondetalle` (
`IDRecepcionDetalle` int(10) NOT NULL,
  `IDRecepcion` int(10) NOT NULL,
  `IDProducto` int(10) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `IVA` decimal(10,2) NOT NULL,
  `Descuento` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remision`
--

DROP TABLE IF EXISTS `remision`;
CREATE TABLE IF NOT EXISTS `remision` (
`IDRemision` int(10) NOT NULL,
  `IDMovimientoAlmacen` int(10) NOT NULL,
  `IDCliente` int(10) NOT NULL,
  `Folio` int(10) NOT NULL,
  `FechaRemision` date NOT NULL,
  `Total` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remisiondetalle`
--

DROP TABLE IF EXISTS `remisiondetalle`;
CREATE TABLE IF NOT EXISTS `remisiondetalle` (
`IDRemisionDetalle` int(10) NOT NULL,
  `IDRemision` int(10) NOT NULL,
  `IDProducto` int(10) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `IVA` decimal(10,2) NOT NULL,
  `Descuento` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocelulitis`
--

DROP TABLE IF EXISTS `tipocelulitis`;
CREATE TABLE IF NOT EXISTS `tipocelulitis` (
`IDTipoCelulitis` int(10) NOT NULL,
  `IDHistorialMedico` int(10) NOT NULL,
  `Fibrosa` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Edematosa` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Flacida` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Dura` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Mixta` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Dolorosa` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ajusteentrada`
--
DROP VIEW IF EXISTS `v_ajusteentrada`;
CREATE TABLE IF NOT EXISTS `v_ajusteentrada` (
`IDAjusteEntrada` int(10)
,`IDMovimientoAlmacen` int(10)
,`Folio` int(10)
,`Tipo` varchar(60)
,`IDCliente` int(10)
,`Cliente` double
,`IDEmpleado` int(10)
,`Empleado` double
,`Observaciones` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ajusteentradadetalle`
--
DROP VIEW IF EXISTS `v_ajusteentradadetalle`;
CREATE TABLE IF NOT EXISTS `v_ajusteentradadetalle` (
`IDAjusteEntradaDetalle` int(10)
,`IDAjusteEntrada` int(10)
,`IDProductoServicio` int(10)
,`Producto` varchar(30)
,`Cantidad` decimal(10,2)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ajustesalida`
--
DROP VIEW IF EXISTS `v_ajustesalida`;
CREATE TABLE IF NOT EXISTS `v_ajustesalida` (
`IDAjusteSalida` int(10)
,`IDMovimientoAlmacen` int(10)
,`Folio` int(10)
,`Tipo` varchar(60)
,`IDProveedor` int(10)
,`Proveedor` double
,`IDEmpleado` int(10)
,`Empleado` double
,`Observaciones` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ajustesalidadetalle`
--
DROP VIEW IF EXISTS `v_ajustesalidadetalle`;
CREATE TABLE IF NOT EXISTS `v_ajustesalidadetalle` (
`IDAjusteSalidaDetalle` int(10)
,`IDAjusteSalida` int(10)
,`IDProductoServicio` int(10)
,`Producto` varchar(30)
,`Cantidad` decimal(10,2)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_cliente`
--
DROP VIEW IF EXISTS `v_cliente`;
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
DROP VIEW IF EXISTS `v_cliente_deleter`;
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
DROP VIEW IF EXISTS `v_consulta`;
CREATE TABLE IF NOT EXISTS `v_consulta` (
`IDConsulta` int(10)
,`IDCliente` int(10)
,`Cliente` double
,`IDTerapeuta` int(10)
,`Terapeuta` double
,`IDProductoServicio` int(10)
,`Producto` varchar(30)
,`FechaCita` date
,`IDHistorialMedico` int(10)
,`Status` varchar(30)
,`Observaciones` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_empleado`
--
DROP VIEW IF EXISTS `v_empleado`;
CREATE TABLE IF NOT EXISTS `v_empleado` (
`IDEmpleado` int(10)
,`Nombre` varchar(30)
,`ApellidoPaterno` varchar(30)
,`ApellidoMaterno` varchar(30)
,`Usuario` varchar(40)
,`Contrasena` varchar(40)
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
DROP VIEW IF EXISTS `v_empleado_deleter`;
CREATE TABLE IF NOT EXISTS `v_empleado_deleter` (
`IDEmpleado` int(10)
,`Nombre` varchar(30)
,`ApellidoPaterno` varchar(30)
,`ApellidoMaterno` varchar(30)
,`Usuario` varchar(40)
,`Contrasena` varchar(40)
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
DROP VIEW IF EXISTS `v_existencia`;
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
DROP VIEW IF EXISTS `v_historialmedico`;
CREATE TABLE IF NOT EXISTS `v_historialmedico` (
`IDHistorialMedico` int(10)
,`IDCliente` int(10)
,`Cliente` double
,`FechaRegistro` timestamp
,`IDServicio` int(10)
,`Producto` varchar(30)
,`Observaciones` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_producto`
--
DROP VIEW IF EXISTS `v_producto`;
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
DROP VIEW IF EXISTS `v_producto_deleter`;
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
DROP VIEW IF EXISTS `v_proveedor`;
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
DROP VIEW IF EXISTS `v_proveedor_deleter`;
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
DROP VIEW IF EXISTS `v_recepcion`;
CREATE TABLE IF NOT EXISTS `v_recepcion` (
`IDRecepcion` int(10)
,`IDMovimientoAlmacen` int(10)
,`Folio` int(10)
,`IDProveedor` int(10)
,`Proveedor` double
,`IDEmpleado` int(10)
,`Empleado` double
,`FechaRecepcion` date
,`Total` decimal(10,2)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_recepciondetalle`
--
DROP VIEW IF EXISTS `v_recepciondetalle`;
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
DROP VIEW IF EXISTS `v_remision`;
CREATE TABLE IF NOT EXISTS `v_remision` (
`IDRemision` int(10)
,`IDMovimientoAlmacen` int(10)
,`Folio` int(10)
,`IDCliente` int(10)
,`Cliente` double
,`IDEmpleado` int(10)
,`Empleado` double
,`FechaRemision` date
,`Total` decimal(10,2)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_remisiondetalle`
--
DROP VIEW IF EXISTS `v_remisiondetalle`;
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
DROP VIEW IF EXISTS `v_servicio`;
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
DROP VIEW IF EXISTS `v_servicio_deleter`;
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
-- Estructura para la vista `v_ajusteentrada`
--
DROP TABLE IF EXISTS `v_ajusteentrada`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ajusteentrada` AS select `ae`.`IDAjusteEntrada` AS `IDAjusteEntrada`,`ae`.`IDMovimientoAlmacen` AS `IDMovimientoAlmacen`,`ae`.`Folio` AS `Folio`,`aet`.`Tipo` AS `Tipo`,`c`.`IDCliente` AS `IDCliente`,((`c`.`Nombre` + `c`.`ApellidoPaterno`) + `c`.`ApellidoMaterno`) AS `Cliente`,`e`.`IDEmpleado` AS `IDEmpleado`,((`e`.`Nombre` + `e`.`ApellidoPaterno`) + `e`.`ApellidoMaterno`) AS `Empleado`,`ae`.`Observaciones` AS `Observaciones` from ((((`ajusteentrada` `ae` join `ajusteentradatipo` `aet` on((`aet`.`IDAjusteEntradaTipo` = `ae`.`IDAjusteEntradaTipo`))) join `cliente` `c` on(((`c`.`IDCliente` = `ae`.`IDCliente`) and (`c`.`Activo` = 'S')))) join `movimientoalmacen` `ma` on((`ma`.`IDMovimientoAlmacen` = `ae`.`IDMovimientoAlmacen`))) join `empleado` `e` on(((`ma`.`IDEmpleado` = `e`.`IDEmpleado`) and (`e`.`Activo` = 'S'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ajusteentradadetalle`
--
DROP TABLE IF EXISTS `v_ajusteentradadetalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ajusteentradadetalle` AS select `aed`.`IDAjusteEntradaDetalle` AS `IDAjusteEntradaDetalle`,`aed`.`IDAjusteEntrada` AS `IDAjusteEntrada`,`aed`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`Producto` AS `Producto`,`aed`.`Cantidad` AS `Cantidad` from (`ajusteentradadetalle` `aed` join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `aed`.`IDProductoServicio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ajustesalida`
--
DROP TABLE IF EXISTS `v_ajustesalida`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ajustesalida` AS select `ae`.`IDAjusteSalida` AS `IDAjusteSalida`,`ae`.`IDMovimientoAlmacen` AS `IDMovimientoAlmacen`,`ae`.`Folio` AS `Folio`,`aet`.`Tipo` AS `Tipo`,`p`.`IDProveedor` AS `IDProveedor`,((`p`.`Nombre` + `p`.`ApellidoPaterno`) + `p`.`ApellidoMaterno`) AS `Proveedor`,`e`.`IDEmpleado` AS `IDEmpleado`,((`e`.`Nombre` + `e`.`ApellidoPaterno`) + `e`.`ApellidoMaterno`) AS `Empleado`,`ae`.`Observaciones` AS `Observaciones` from ((((`ajustesalida` `ae` join `ajustesalidatipo` `aet` on((`aet`.`IDAjusteSalidaTipo` = `ae`.`IDAjusteSalidaTipo`))) join `proveedor` `p` on(((`p`.`IDProveedor` = `ae`.`IDProveedor`) and (`p`.`Activo` = 'S')))) join `movimientoalmacen` `ma` on((`ma`.`IDMovimientoAlmacen` = `ae`.`IDMovimientoAlmacen`))) join `empleado` `e` on(((`ma`.`IDEmpleado` = `e`.`IDEmpleado`) and (`e`.`Activo` = 'S'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ajustesalidadetalle`
--
DROP TABLE IF EXISTS `v_ajustesalidadetalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ajustesalidadetalle` AS select `asd`.`IDAjusteSalidaDetalle` AS `IDAjusteSalidaDetalle`,`asd`.`IDAjusteSalida` AS `IDAjusteSalida`,`asd`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`Producto` AS `Producto`,`asd`.`Cantidad` AS `Cantidad` from (`ajustesalidadetalle` `asd` join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `asd`.`IDProductoServicio`)));

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_consulta` AS select `con`.`IDConsulta` AS `IDConsulta`,`con`.`IDCliente` AS `IDCliente`,((`c`.`Nombre` + `c`.`ApellidoPaterno`) + `c`.`ApellidoMaterno`) AS `Cliente`,`con`.`IDTerapeuta` AS `IDTerapeuta`,((`e`.`Nombre` + `e`.`ApellidoPaterno`) + `e`.`ApellidoMaterno`) AS `Terapeuta`,`ps`.`IDProductoServicio` AS `IDProductoServicio`,`ps`.`Producto` AS `Producto`,`con`.`FechaCita` AS `FechaCita`,`con`.`IDHistorialMedico` AS `IDHistorialMedico`,`cs`.`Status` AS `Status`,`con`.`observaciones` AS `Observaciones` from (((((`consulta` `con` join `consultastatus` `cs` on((`cs`.`IDConsultaStatus` = `con`.`IDConsultaStatus`))) join `cliente` `c` on(((`c`.`IDCliente` = `con`.`IDCliente`) and (`c`.`Activo` = 'S')))) join `empleado` `e` on(((`e`.`IDEmpleado` = `con`.`IDTerapeuta`) and (`e`.`Activo` = 'S')))) join `historialmedico` `hm` on((`hm`.`IDHistorialMedico` = `con`.`IDHistorialMedico`))) join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `hm`.`IDServicio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_empleado`
--
DROP TABLE IF EXISTS `v_empleado`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_empleado` AS select `e`.`IDEmpleado` AS `IDEmpleado`,`e`.`Nombre` AS `Nombre`,`e`.`ApellidoPaterno` AS `ApellidoPaterno`,`e`.`ApellidoMaterno` AS `ApellidoMaterno`,`e`.`Usuario` AS `Usuario`,`e`.`Contrasena` AS `Contrasena`,`c`.`Cargo` AS `Cargo`,`e`.`Calle` AS `Calle`,`e`.`NumExterior` AS `NumExterior`,`e`.`NumInterior` AS `NumInterior`,`e`.`Colonia` AS `Colonia`,`e`.`CodigoPostal` AS `CP`,`e`.`Foto` AS `Foto`,`e`.`Email` AS `Email`,`e`.`Telefono` AS `Telefono`,`e`.`Celular` AS `Celular` from (`empleado` `e` join `cargo` `c` on(((`c`.`IDCargo` = `e`.`IDCargo`) and (`e`.`Activo` = 'S'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_empleado_deleter`
--
DROP TABLE IF EXISTS `v_empleado_deleter`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_empleado_deleter` AS select `e`.`IDEmpleado` AS `IDEmpleado`,`e`.`Nombre` AS `Nombre`,`e`.`ApellidoPaterno` AS `ApellidoPaterno`,`e`.`ApellidoMaterno` AS `ApellidoMaterno`,`e`.`Usuario` AS `Usuario`,`e`.`Contrasena` AS `Contrasena`,`c`.`Cargo` AS `Cargo`,`e`.`Calle` AS `Calle`,`e`.`NumExterior` AS `NumExterior`,`e`.`NumInterior` AS `NumInterior`,`e`.`Colonia` AS `Colonia`,`e`.`CodigoPostal` AS `CP`,`e`.`Foto` AS `Foto`,`e`.`Email` AS `Email`,`e`.`Telefono` AS `Telefono`,`e`.`Celular` AS `Celular` from (`empleado` `e` join `cargo` `c` on(((`c`.`IDCargo` = `e`.`IDCargo`) and (`e`.`Activo` = 'N'))));

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_historialmedico` AS select `hm`.`IDHistorialMedico` AS `IDHistorialMedico`,`hm`.`IDCliente` AS `IDCliente`,((`c`.`Nombre` + `c`.`ApellidoPaterno`) + `c`.`ApellidoMaterno`) AS `Cliente`,`hm`.`FechaRegistro` AS `FechaRegistro`,`hm`.`IDServicio` AS `IDServicio`,`ps`.`Producto` AS `Producto`,`hm`.`observaciones` AS `Observaciones` from ((`historialmedico` `hm` join `cliente` `c` on(((`c`.`IDCliente` = `hm`.`IDCliente`) and (`c`.`Activo` = 'S')))) join `productoservicio` `ps` on((`ps`.`IDProductoServicio` = `hm`.`IDServicio`)));

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_recepcion` AS select `rec`.`IDRecepcion` AS `IDRecepcion`,`rec`.`IDMovimientoAlmacen` AS `IDMovimientoAlmacen`,`rec`.`Folio` AS `Folio`,`p`.`IDProveedor` AS `IDProveedor`,((`p`.`Nombre` + `p`.`ApellidoPaterno`) + `p`.`ApellidoMaterno`) AS `Proveedor`,`e`.`IDEmpleado` AS `IDEmpleado`,((`e`.`Nombre` + `e`.`ApellidoPaterno`) + `e`.`ApellidoMaterno`) AS `Empleado`,`rec`.`FechaRecepcion` AS `FechaRecepcion`,`rec`.`Total` AS `Total` from (((`recepcion` `rec` join `proveedor` `p` on(((`p`.`IDProveedor` = `rec`.`IDProveedor`) and (`p`.`Activo` = 'S')))) join `movimientoalmacen` `ma` on((`ma`.`IDMovimientoAlmacen` = `rec`.`IDMovimientoAlmacen`))) join `empleado` `e` on(((`e`.`IDEmpleado` = `ma`.`IDEmpleado`) and (`e`.`Activo` = 'S'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_recepciondetalle`
--
DROP TABLE IF EXISTS `v_recepciondetalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_recepciondetalle` AS select `recd`.`IDRecepcionDetalle` AS `IDRecepcionDetalle`,`recd`.`IDRecepcion` AS `IDRecepcion`,`recd`.`IDProducto` AS `IDProducto`,`ps`.`Producto` AS `Producto`,`recd`.`Cantidad` AS `Cantidad`,`recd`.`PrecioUnitario` AS `PrecioUnitario`,`recd`.`IVA` AS `IVA`,`recd`.`Descuento` AS `Descuento` from (`recepciondetalle` `recd` join `productoservicio` `ps` on((`ps`.`IDProductoServicioTipo` = `recd`.`IDProducto`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_remision`
--
DROP TABLE IF EXISTS `v_remision`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_remision` AS select `rem`.`IDRemision` AS `IDRemision`,`rem`.`IDMovimientoAlmacen` AS `IDMovimientoAlmacen`,`rem`.`Folio` AS `Folio`,`c`.`IDCliente` AS `IDCliente`,((`c`.`Nombre` + `c`.`ApellidoPaterno`) + `c`.`ApellidoMaterno`) AS `Cliente`,`e`.`IDEmpleado` AS `IDEmpleado`,((`e`.`Nombre` + `e`.`ApellidoPaterno`) + `e`.`ApellidoMaterno`) AS `Empleado`,`rem`.`FechaRemision` AS `FechaRemision`,`rem`.`Total` AS `Total` from (((`remision` `rem` join `cliente` `c` on(((`c`.`IDCliente` = `rem`.`IDCliente`) and (`c`.`Activo` = 'S')))) join `movimientoalmacen` `ma` on((`ma`.`IDMovimientoAlmacen` = `rem`.`IDMovimientoAlmacen`))) join `empleado` `e` on(((`e`.`IDEmpleado` = `ma`.`IDEmpleado`) and (`e`.`Activo` = 'S'))));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_remisiondetalle`
--
DROP TABLE IF EXISTS `v_remisiondetalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_remisiondetalle` AS select `remd`.`IDRemisionDetalle` AS `IDRemisionDetalle`,`remd`.`IDRemision` AS `IDRemision`,`remd`.`IDProducto` AS `IDProducto`,`ps`.`Producto` AS `Producto`,`remd`.`Cantidad` AS `Cantidad`,`remd`.`PrecioUnitario` AS `PrecioUnitario`,`remd`.`IVA` AS `IVA`,`remd`.`Descuento` AS `Descuento` from (`remisiondetalle` `remd` join `productoservicio` `ps` on((`ps`.`IDProductoServicioTipo` = `remd`.`IDProducto`)));

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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aguaaldia`
--
ALTER TABLE `aguaaldia`
 ADD PRIMARY KEY (`IDAguaAlDia`,`IDHistorialMedico`), ADD UNIQUE KEY `IDAguaAlDia` (`IDAguaAlDia`), ADD KEY `FKAguaAlDia625443` (`IDHistorialMedico`);

--
-- Indices de la tabla `ajusteentrada`
--
ALTER TABLE `ajusteentrada`
 ADD PRIMARY KEY (`IDAjusteEntrada`,`IDMovimientoAlmacen`), ADD UNIQUE KEY `IDAjusteEntrada` (`IDAjusteEntrada`), ADD UNIQUE KEY `Folio` (`Folio`), ADD KEY `FKAjusteEntr817793` (`IDMovimientoAlmacen`), ADD KEY `FKAjusteEntr762431` (`IDCliente`), ADD KEY `FKAjusteEntr133801` (`IDAjusteEntradaTipo`);

--
-- Indices de la tabla `ajusteentradadetalle`
--
ALTER TABLE `ajusteentradadetalle`
 ADD PRIMARY KEY (`IDAjusteEntradaDetalle`,`IDAjusteEntrada`), ADD UNIQUE KEY `IDAjusteEntradaDetalle` (`IDAjusteEntradaDetalle`), ADD KEY `FKAjusteEntr965676` (`IDAjusteEntrada`), ADD KEY `FKAjusteEntr951580` (`IDProductoServicio`);

--
-- Indices de la tabla `ajusteentradatipo`
--
ALTER TABLE `ajusteentradatipo`
 ADD PRIMARY KEY (`IDAjusteEntradaTipo`), ADD UNIQUE KEY `IDAjusteEntradaTipo` (`IDAjusteEntradaTipo`);

--
-- Indices de la tabla `ajustesalida`
--
ALTER TABLE `ajustesalida`
 ADD PRIMARY KEY (`IDAjusteSalida`,`IDMovimientoAlmacen`), ADD UNIQUE KEY `IDAjusteSalida` (`IDAjusteSalida`), ADD UNIQUE KEY `Folio` (`Folio`), ADD KEY `FKAjusteSali232744` (`IDMovimientoAlmacen`), ADD KEY `FKAjusteSali566873` (`IDProveedor`), ADD KEY `FKAjusteSali329927` (`IDAjusteSalidaTipo`);

--
-- Indices de la tabla `ajustesalidadetalle`
--
ALTER TABLE `ajustesalidadetalle`
 ADD PRIMARY KEY (`IDAjusteSalidaDetalle`,`IDAjusteSalida`), ADD UNIQUE KEY `IDAjusteSalidaDetalle` (`IDAjusteSalidaDetalle`), ADD KEY `FKAjusteSali199966` (`IDAjusteSalida`), ADD KEY `FKAjusteSali116948` (`IDProductoServicio`);

--
-- Indices de la tabla `ajustesalidatipo`
--
ALTER TABLE `ajustesalidatipo`
 ADD PRIMARY KEY (`IDAjusteSalidaTipo`), ADD UNIQUE KEY `IDAjusteSalidaTipo` (`IDAjusteSalidaTipo`);

--
-- Indices de la tabla `alimentacion`
--
ALTER TABLE `alimentacion`
 ADD PRIMARY KEY (`IDAlimentacion`,`IDHistorialMedico`), ADD UNIQUE KEY `IDAlimentacion` (`IDAlimentacion`), ADD KEY `FKAlimentaci962672` (`IDHistorialMedico`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
 ADD PRIMARY KEY (`IDCargo`), ADD UNIQUE KEY `IDCargo` (`IDCargo`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
 ADD PRIMARY KEY (`IDCliente`), ADD UNIQUE KEY `IDCliente` (`IDCliente`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
 ADD PRIMARY KEY (`IDConsulta`), ADD UNIQUE KEY `IDConsulta` (`IDConsulta`), ADD KEY `FKConsulta393400` (`IDConsultaStatus`), ADD KEY `FKConsulta287998` (`IDCliente`), ADD KEY `FKConsulta768151` (`IDTerapeuta`), ADD KEY `FKConsulta744754` (`IDHistorialMedico`);

--
-- Indices de la tabla `consultastatus`
--
ALTER TABLE `consultastatus`
 ADD PRIMARY KEY (`IDConsultaStatus`), ADD UNIQUE KEY `IDConsultaStatus` (`IDConsultaStatus`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
 ADD PRIMARY KEY (`IDEmpleado`), ADD UNIQUE KEY `IDEmpleado` (`IDEmpleado`), ADD UNIQUE KEY `Usuario` (`Usuario`), ADD KEY `FKEmpleado545786` (`IDCargo`), ADD KEY `IDEX_Usuario` (`Usuario`) USING BTREE;

--
-- Indices de la tabla `empleadosueldo`
--
ALTER TABLE `empleadosueldo`
 ADD PRIMARY KEY (`IDSueldoEmpleado`), ADD KEY `IDEmpleado` (`IDEmpleado`);

--
-- Indices de la tabla `exfoliacion`
--
ALTER TABLE `exfoliacion`
 ADD PRIMARY KEY (`IDExfoliacion`,`IDHistorialMedico`), ADD UNIQUE KEY `IDExfoliacion` (`IDExfoliacion`), ADD KEY `FKExfoliacio997845` (`IDHistorialMedico`);

--
-- Indices de la tabla `existencia`
--
ALTER TABLE `existencia`
 ADD PRIMARY KEY (`IDExistencia`,`FechaReferencia`), ADD UNIQUE KEY `IDExistencia` (`IDExistencia`), ADD KEY `FKExistencia174224` (`IDProductoServicio`);

--
-- Indices de la tabla `exploracionfinal`
--
ALTER TABLE `exploracionfinal`
 ADD PRIMARY KEY (`IDExploracionFinal`,`IDHistorialMedico`), ADD UNIQUE KEY `IDExploracionFinal` (`IDExploracionFinal`), ADD KEY `IDHistorialMedico` (`IDHistorialMedico`);

--
-- Indices de la tabla `exploracioninicial`
--
ALTER TABLE `exploracioninicial`
 ADD PRIMARY KEY (`IDExploracionInicial`,`IDHistorialMedico`), ADD UNIQUE KEY `IDExploracionInicial` (`IDExploracionInicial`), ADD KEY `IDHistorialMedico` (`IDHistorialMedico`);

--
-- Indices de la tabla `fichaclinica`
--
ALTER TABLE `fichaclinica`
 ADD PRIMARY KEY (`IDFichaClinica`,`IDHistorialMedico`), ADD UNIQUE KEY `IDFichaClinica` (`IDFichaClinica`), ADD KEY `FKFichaClini138377` (`IDHistorialMedico`);

--
-- Indices de la tabla `habito`
--
ALTER TABLE `habito`
 ADD PRIMARY KEY (`IDHabito`,`IDHistorialMedico`), ADD UNIQUE KEY `IDHabito` (`IDHabito`), ADD KEY `FKHabito806866` (`IDHistorialMedico`);

--
-- Indices de la tabla `historialmedico`
--
ALTER TABLE `historialmedico`
 ADD PRIMARY KEY (`IDHistorialMedico`,`IDCliente`), ADD UNIQUE KEY `IDHistorialMedico` (`IDHistorialMedico`), ADD KEY `FKHistorialM959828` (`IDServicio`), ADD KEY `FKHistorialM865695` (`IDCliente`);

--
-- Indices de la tabla `movimientoalmacen`
--
ALTER TABLE `movimientoalmacen`
 ADD PRIMARY KEY (`IDMovimientoAlmacen`), ADD UNIQUE KEY `IDMovimientoAlmacen` (`IDMovimientoAlmacen`), ADD KEY `FKMovimiento137480` (`IDMovimientoAlmacenTipo`), ADD KEY `FKMovimiento729160` (`IDEmpleado`);

--
-- Indices de la tabla `movimientoalmacentipo`
--
ALTER TABLE `movimientoalmacentipo`
 ADD PRIMARY KEY (`IDMovimientoAlmacenTipo`), ADD UNIQUE KEY `IDMovimientoAlmacenTipo` (`IDMovimientoAlmacenTipo`);

--
-- Indices de la tabla `padecimiento`
--
ALTER TABLE `padecimiento`
 ADD PRIMARY KEY (`IDPadecimiento`,`IDHistorialMedico`), ADD UNIQUE KEY `IDPadecimiento` (`IDPadecimiento`), ADD KEY `FKPadecimien990892` (`IDHistorialMedico`);

--
-- Indices de la tabla `piel`
--
ALTER TABLE `piel`
 ADD PRIMARY KEY (`IDPiel`,`IDHistorialMedico`), ADD UNIQUE KEY `IDPiel` (`IDPiel`), ADD KEY `FKPiel612399` (`IDHistorialMedico`);

--
-- Indices de la tabla `productoservicio`
--
ALTER TABLE `productoservicio`
 ADD PRIMARY KEY (`IDProductoServicio`), ADD UNIQUE KEY `IDProductoServicio` (`IDProductoServicio`), ADD KEY `FKProductoSe737139` (`IDProductoServicioTipo`);

--
-- Indices de la tabla `productoserviciotipo`
--
ALTER TABLE `productoserviciotipo`
 ADD PRIMARY KEY (`IDProductoServicioTipo`), ADD UNIQUE KEY `IDProductoServicioTipo` (`IDProductoServicioTipo`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
 ADD PRIMARY KEY (`IDProveedor`), ADD UNIQUE KEY `IDProveedor` (`IDProveedor`), ADD UNIQUE KEY `RFC` (`RFC`);

--
-- Indices de la tabla `recepcion`
--
ALTER TABLE `recepcion`
 ADD PRIMARY KEY (`IDRecepcion`,`IDMovimientoAlmacen`), ADD UNIQUE KEY `IDRecepcion` (`IDRecepcion`), ADD UNIQUE KEY `Folio` (`Folio`), ADD KEY `FKRecepcion658770` (`IDProveedor`), ADD KEY `FKRecepcion859152` (`IDMovimientoAlmacen`);

--
-- Indices de la tabla `recepciondetalle`
--
ALTER TABLE `recepciondetalle`
 ADD PRIMARY KEY (`IDRecepcionDetalle`,`IDRecepcion`), ADD UNIQUE KEY `IDRecepcionDetalle` (`IDRecepcionDetalle`), ADD KEY `FKRecepcionD531606` (`IDProducto`), ADD KEY `FKRecepcionD845984` (`IDRecepcion`);

--
-- Indices de la tabla `remision`
--
ALTER TABLE `remision`
 ADD PRIMARY KEY (`IDRemision`,`IDMovimientoAlmacen`), ADD UNIQUE KEY `IDRemision` (`IDRemision`), ADD UNIQUE KEY `Folio` (`Folio`), ADD KEY `FKRemision665472` (`IDMovimientoAlmacen`), ADD KEY `FKRemision610110` (`IDCliente`);

--
-- Indices de la tabla `remisiondetalle`
--
ALTER TABLE `remisiondetalle`
 ADD PRIMARY KEY (`IDRemisionDetalle`,`IDRemision`), ADD UNIQUE KEY `IDRemisionDetalle` (`IDRemisionDetalle`), ADD KEY `FKRemisionDe671804` (`IDRemision`), ADD KEY `FKRemisionDe425762` (`IDProducto`);

--
-- Indices de la tabla `tipocelulitis`
--
ALTER TABLE `tipocelulitis`
 ADD PRIMARY KEY (`IDTipoCelulitis`,`IDHistorialMedico`), ADD UNIQUE KEY `IDTipoCelulitis` (`IDTipoCelulitis`), ADD KEY `FKTipoCeluli51692` (`IDHistorialMedico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aguaaldia`
--
ALTER TABLE `aguaaldia`
MODIFY `IDAguaAlDia` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ajusteentrada`
--
ALTER TABLE `ajusteentrada`
MODIFY `IDAjusteEntrada` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ajusteentradadetalle`
--
ALTER TABLE `ajusteentradadetalle`
MODIFY `IDAjusteEntradaDetalle` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ajusteentradatipo`
--
ALTER TABLE `ajusteentradatipo`
MODIFY `IDAjusteEntradaTipo` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `ajustesalida`
--
ALTER TABLE `ajustesalida`
MODIFY `IDAjusteSalida` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ajustesalidadetalle`
--
ALTER TABLE `ajustesalidadetalle`
MODIFY `IDAjusteSalidaDetalle` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ajustesalidatipo`
--
ALTER TABLE `ajustesalidatipo`
MODIFY `IDAjusteSalidaTipo` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `alimentacion`
--
ALTER TABLE `alimentacion`
MODIFY `IDAlimentacion` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
MODIFY `IDCargo` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
MODIFY `IDCliente` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
MODIFY `IDConsulta` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `consultastatus`
--
ALTER TABLE `consultastatus`
MODIFY `IDConsultaStatus` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
MODIFY `IDEmpleado` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `empleadosueldo`
--
ALTER TABLE `empleadosueldo`
MODIFY `IDSueldoEmpleado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `exfoliacion`
--
ALTER TABLE `exfoliacion`
MODIFY `IDExfoliacion` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `existencia`
--
ALTER TABLE `existencia`
MODIFY `IDExistencia` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `exploracionfinal`
--
ALTER TABLE `exploracionfinal`
MODIFY `IDExploracionFinal` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `exploracioninicial`
--
ALTER TABLE `exploracioninicial`
MODIFY `IDExploracionInicial` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `fichaclinica`
--
ALTER TABLE `fichaclinica`
MODIFY `IDFichaClinica` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `habito`
--
ALTER TABLE `habito`
MODIFY `IDHabito` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `historialmedico`
--
ALTER TABLE `historialmedico`
MODIFY `IDHistorialMedico` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `movimientoalmacen`
--
ALTER TABLE `movimientoalmacen`
MODIFY `IDMovimientoAlmacen` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `movimientoalmacentipo`
--
ALTER TABLE `movimientoalmacentipo`
MODIFY `IDMovimientoAlmacenTipo` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `padecimiento`
--
ALTER TABLE `padecimiento`
MODIFY `IDPadecimiento` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `piel`
--
ALTER TABLE `piel`
MODIFY `IDPiel` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `productoservicio`
--
ALTER TABLE `productoservicio`
MODIFY `IDProductoServicio` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `productoserviciotipo`
--
ALTER TABLE `productoserviciotipo`
MODIFY `IDProductoServicioTipo` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
MODIFY `IDProveedor` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recepcion`
--
ALTER TABLE `recepcion`
MODIFY `IDRecepcion` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recepciondetalle`
--
ALTER TABLE `recepciondetalle`
MODIFY `IDRecepcionDetalle` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `remision`
--
ALTER TABLE `remision`
MODIFY `IDRemision` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `remisiondetalle`
--
ALTER TABLE `remisiondetalle`
MODIFY `IDRemisionDetalle` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipocelulitis`
--
ALTER TABLE `tipocelulitis`
MODIFY `IDTipoCelulitis` int(10) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aguaaldia`
--
ALTER TABLE `aguaaldia`
ADD CONSTRAINT `FKAguaAlDia625443` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `ajusteentrada`
--
ALTER TABLE `ajusteentrada`
ADD CONSTRAINT `FKAjusteEntr133801` FOREIGN KEY (`IDAjusteEntradaTipo`) REFERENCES `ajusteentradatipo` (`IDAjusteEntradaTipo`),
ADD CONSTRAINT `FKAjusteEntr762431` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`),
ADD CONSTRAINT `FKAjusteEntr817793` FOREIGN KEY (`IDMovimientoAlmacen`) REFERENCES `movimientoalmacen` (`IDMovimientoAlmacen`);

--
-- Filtros para la tabla `ajusteentradadetalle`
--
ALTER TABLE `ajusteentradadetalle`
ADD CONSTRAINT `FKAjusteEntr951580` FOREIGN KEY (`IDProductoServicio`) REFERENCES `productoservicio` (`IDProductoServicio`),
ADD CONSTRAINT `FKAjusteEntr965676` FOREIGN KEY (`IDAjusteEntrada`) REFERENCES `ajusteentrada` (`IDAjusteEntrada`);

--
-- Filtros para la tabla `ajustesalida`
--
ALTER TABLE `ajustesalida`
ADD CONSTRAINT `FKAjusteSali232744` FOREIGN KEY (`IDMovimientoAlmacen`) REFERENCES `movimientoalmacen` (`IDMovimientoAlmacen`),
ADD CONSTRAINT `FKAjusteSali329927` FOREIGN KEY (`IDAjusteSalidaTipo`) REFERENCES `ajustesalidatipo` (`IDAjusteSalidaTipo`),
ADD CONSTRAINT `FKAjusteSali566873` FOREIGN KEY (`IDProveedor`) REFERENCES `proveedor` (`IDProveedor`);

--
-- Filtros para la tabla `ajustesalidadetalle`
--
ALTER TABLE `ajustesalidadetalle`
ADD CONSTRAINT `FKAjusteSali116948` FOREIGN KEY (`IDProductoServicio`) REFERENCES `productoservicio` (`IDProductoServicio`),
ADD CONSTRAINT `FKAjusteSali199966` FOREIGN KEY (`IDAjusteSalida`) REFERENCES `ajustesalida` (`IDAjusteSalida`);

--
-- Filtros para la tabla `alimentacion`
--
ALTER TABLE `alimentacion`
ADD CONSTRAINT `FKAlimentaci962672` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
ADD CONSTRAINT `FKConsulta287998` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`),
ADD CONSTRAINT `FKConsulta393400` FOREIGN KEY (`IDConsultaStatus`) REFERENCES `consultastatus` (`IDConsultaStatus`),
ADD CONSTRAINT `FKConsulta744754` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`),
ADD CONSTRAINT `FKConsulta768151` FOREIGN KEY (`IDTerapeuta`) REFERENCES `empleado` (`IDEmpleado`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
ADD CONSTRAINT `FKEmpleado545786` FOREIGN KEY (`IDCargo`) REFERENCES `cargo` (`IDCargo`);

--
-- Filtros para la tabla `empleadosueldo`
--
ALTER TABLE `empleadosueldo`
ADD CONSTRAINT `EmpleadoSueldo_ibfk_1` FOREIGN KEY (`IDEmpleado`) REFERENCES `empleado` (`IDEmpleado`);

--
-- Filtros para la tabla `exfoliacion`
--
ALTER TABLE `exfoliacion`
ADD CONSTRAINT `FKExfoliacio997845` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `existencia`
--
ALTER TABLE `existencia`
ADD CONSTRAINT `FKExistencia174224` FOREIGN KEY (`IDProductoServicio`) REFERENCES `productoservicio` (`IDProductoServicio`);

--
-- Filtros para la tabla `exploracionfinal`
--
ALTER TABLE `exploracionfinal`
ADD CONSTRAINT `ExploracionFinal_ibfk_1` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `exploracioninicial`
--
ALTER TABLE `exploracioninicial`
ADD CONSTRAINT `ExploracionInicial_ibfk_1` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `fichaclinica`
--
ALTER TABLE `fichaclinica`
ADD CONSTRAINT `FKFichaClini138377` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `habito`
--
ALTER TABLE `habito`
ADD CONSTRAINT `FKHabito806866` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `historialmedico`
--
ALTER TABLE `historialmedico`
ADD CONSTRAINT `FKHistorialM865695` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`),
ADD CONSTRAINT `FKHistorialM959828` FOREIGN KEY (`IDServicio`) REFERENCES `productoservicio` (`IDProductoServicio`);

--
-- Filtros para la tabla `movimientoalmacen`
--
ALTER TABLE `movimientoalmacen`
ADD CONSTRAINT `FKMovimiento137480` FOREIGN KEY (`IDMovimientoAlmacenTipo`) REFERENCES `movimientoalmacentipo` (`IDMovimientoAlmacenTipo`),
ADD CONSTRAINT `FKMovimiento729160` FOREIGN KEY (`IDEmpleado`) REFERENCES `empleado` (`IDEmpleado`);

--
-- Filtros para la tabla `padecimiento`
--
ALTER TABLE `padecimiento`
ADD CONSTRAINT `FKPadecimien990892` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `piel`
--
ALTER TABLE `piel`
ADD CONSTRAINT `FKPiel612399` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

--
-- Filtros para la tabla `productoservicio`
--
ALTER TABLE `productoservicio`
ADD CONSTRAINT `FKProductoSe737139` FOREIGN KEY (`IDProductoServicioTipo`) REFERENCES `productoserviciotipo` (`IDProductoServicioTipo`);

--
-- Filtros para la tabla `recepcion`
--
ALTER TABLE `recepcion`
ADD CONSTRAINT `FKRecepcion658770` FOREIGN KEY (`IDProveedor`) REFERENCES `proveedor` (`IDProveedor`),
ADD CONSTRAINT `FKRecepcion859152` FOREIGN KEY (`IDMovimientoAlmacen`) REFERENCES `movimientoalmacen` (`IDMovimientoAlmacen`);

--
-- Filtros para la tabla `recepciondetalle`
--
ALTER TABLE `recepciondetalle`
ADD CONSTRAINT `FKRecepcionD531606` FOREIGN KEY (`IDProducto`) REFERENCES `productoservicio` (`IDProductoServicio`),
ADD CONSTRAINT `FKRecepcionD845984` FOREIGN KEY (`IDRecepcion`) REFERENCES `recepcion` (`IDRecepcion`);

--
-- Filtros para la tabla `remision`
--
ALTER TABLE `remision`
ADD CONSTRAINT `FKRemision610110` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`),
ADD CONSTRAINT `FKRemision665472` FOREIGN KEY (`IDMovimientoAlmacen`) REFERENCES `movimientoalmacen` (`IDMovimientoAlmacen`);

--
-- Filtros para la tabla `remisiondetalle`
--
ALTER TABLE `remisiondetalle`
ADD CONSTRAINT `FKRemisionDe425762` FOREIGN KEY (`IDProducto`) REFERENCES `productoservicio` (`IDProductoServicio`),
ADD CONSTRAINT `FKRemisionDe671804` FOREIGN KEY (`IDRemision`) REFERENCES `remision` (`IDRemision`);

--
-- Filtros para la tabla `tipocelulitis`
--
ALTER TABLE `tipocelulitis`
ADD CONSTRAINT `FKTipoCeluli51692` FOREIGN KEY (`IDHistorialMedico`) REFERENCES `historialmedico` (`IDHistorialMedico`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
