/*Cliente*/
INSERT INTO `spadamaris`.`cliente` (`IDCliente`, `Nombre`, `ApellidoPaterno`, `ApellidoMaterno`, `Calle`, `NumExterior`, `NumInterior`, `Colonia`, `CodigoPostal`, `Email`, `Telefono`, `Celular`, `Activo`) VALUES (NULL, 'Christian', 'Velázquez', 'Pérez', 'Volcán Usulutan', '55', '3', 'Huentitán el Bajo', '44250', 'chris_abimael@hotmail.com', '36516998', '3310180877', 'N');

/*Empleado*/


/*Proveedor*/
INSERT INTO `spadamaris`.`proveedor` (`IDProveedor`, `Nombre`, `ApellidoPaterno`, `ApellidoMaterno`, `RFC`, `Calle`, `NumExterior`, `NumInterior`, `Colonia`, `CodigoPostal`, `Email`, `Telefono`, `Celular`, `Activo`) VALUES (NULL, 'Paco', 'Matrinez', 'Jiménez', NULL, 'Periférico Norte', '2341', '2', 'San Ignacio', '44550', NULL, NULL, NULL, 'N');

/*Producto*/
INSERT INTO `spadamaris`.`productoservicio` (`IDProductoServicio`, `IDProductoServicioTipo`, `Producto`, `PrecioUnitario`, `Foto`, `Descripcion`, `Activo`) VALUES (NULL, '1', 'Crema', '15.50', NULL, NULL, 'S'), (NULL, '1', 'Toalla', '50.00', NULL, NULL, 'N');

/*Servicio*/
INSERT INTO `spadamaris`.`productoservicio` (`IDProductoServicio`, `IDProductoServicioTipo`, `Producto`, `PrecioUnitario`, `Foto`, `Descripcion`, `Activo`) VALUES (NULL, '2', 'Baño de Juva', '200.00', NULL, NULL, 'S');
INSERT INTO `spadamaris`.`productoservicio` (`IDProductoServicio`, `IDProductoServicioTipo`, `Producto`, `PrecioUnitario`, `Foto`, `Descripcion`, `Activo`) VALUES (NULL, '2', 'Pedicure', '150.99', NULL, NULL, 'N');

/*Movimiento Almacen*/
INSERT INTO `spadamaris`.`movimientoalmacen` (`IDMovimientoAlmacen`, `IDMovimientoAlmacenTipo`, `IDEmpleado`) VALUES (NULL, '3', '1');
INSERT INTO `spadamaris`.`movimientoalmacen` (`IDMovimientoAlmacen`, `IDMovimientoAlmacenTipo`, `IDEmpleado`) VALUES (NULL, '4', '1');
INSERT INTO `spadamaris`.`movimientoalmacen` (`IDMovimientoAlmacen`, `IDMovimientoAlmacenTipo`, `IDEmpleado`) VALUES (NULL, '1', '1');

/*Remisión*/
INSERT INTO `spadamaris`.`remision` (`IDRemision`, `IDMovimientoAlmacen`, `IDCliente`, `Folio`, `FechaRemision`, `Total`) VALUES (NULL, '1', '1', '1', '2014-11-15', '0.00');

/*Recepción*/
INSERT INTO `spadamaris`.`recepcion` (`IDRecepcion`, `IDMovimientoAlmacen`, `IDProveedor`, `Folio`, `FechaRecepcion`, `Total`) VALUES (NULL, '2', '1', '2', '2014-11-14', '0.00');

/*Ajuste de Entrada*/
INSERT INTO `spadamaris`.`ajusteentrada` (`IDAjusteEntrada`, `IDMovimientoAlmacen`, `IDAjusteEntradaTipo`, `IDCliente`, `Folio`, `Observaciones`) VALUES (NULL, '3', '1', NULL, '1', NULL);

/*Existencia*/
INSERT INTO `spadamaris`.`existencia` (`IDExistencia`, `FechaReferencia`, `IDProductoServicio`, `PrecioUnitario`, `Cantidad`) VALUES (NULL, '15/11/2014', '1', '30.00', '10');

