CREATE VIEW V_Empleado_Deleter AS
SELECT IDEmpleado, Nombre, ApellidoPaterno, ApellidoMaterno, 
Usuario, Contrasena, e.IDCargo, c.Cargo as Cargo, Calle, NumExterior, 
NumInterior, Colonia, CodigoPostal as CP, Foto, Email, Telefono, Celular 
From Empleado e 
inner join Cargo c 
on c.IDCargo=e.IDCargo and e.Activo='N';

CREATE VIEW V_Empleado AS
SELECT IDEmpleado, Nombre, ApellidoPaterno, ApellidoMaterno, 
Usuario, Contrasena, e.IDCargo, c.Cargo as Cargo, Calle, NumExterior, 
NumInterior, Colonia, CodigoPostal as CP, Foto, Email, Telefono, Celular 
From Empleado e 
inner join Cargo c 
on c.IDCargo=e.IDCargo and e.Activo='S';

CREATE VIEW V_AjusteEntrada AS
SELECT IDAjusteEntrada, ae.IDMovimientoAlmacen, Folio, ae.IDAjusteEntradaTipo,aet.Tipo, c.IDCliente, CONCAT_WS(' ',c.Nombre,c.ApellidoPaterno,c.ApellidoMaterno) as Cliente, e.IDEmpleado, CONCAT_WS(' ',e.Nombre,e.ApellidoPaterno,e.ApellidoMaterno) as Empleado, Total, Observaciones
From AjusteEntrada ae
inner join AjusteEntradaTipo aet
on aet.IDAjusteEntradaTipo=ae.IDAjusteEntradaTipo
left join Cliente c
on c.IDCliente=ae.IDCliente AND c.Activo= 'S'
inner join MovimientoAlmacen ma
on ma.IDMovimientoAlmacen=ae.IDMovimientoAlmacen
inner join Empleado e
on ma.IDEmpleado=e.IDEmpleado and e.Activo='S';

CREATE VIEW V_AjusteSalida AS
SELECT IDAjusteSalida, asa.IDMovimientoAlmacen, Folio, asa.IDAjusteSalidaTipo,asat.Tipo, p.IDProveedor, CONCAT_WS(' ',p.Nombre,p.ApellidoPaterno,p.ApellidoMaterno) as Proveedor, e.IDEmpleado, CONCAT_WS(' ',e.Nombre,e.ApellidoPaterno,e.ApellidoMaterno) as Empleado, Total, Observaciones
From AjusteSalida asa
inner join AjusteSalidaTipo asat
on asat.IDAjusteSalidaTipo=asa.IDAjusteSalidaTipo
left join Proveedor p
on p.IDProveedor=asa.IDProveedor and p.Activo='S'
inner join MovimientoAlmacen ma
on ma.IDMovimientoAlmacen=asa.IDMovimientoAlmacen
inner join Empleado e
on ma.IDEmpleado=e.IDEmpleado and e.Activo='S';

CREATE VIEW V_Consulta AS
SELECT IDConsulta, con.IDCliente, CONCAT_WS(' ',c.Nombre,c.ApellidoPaterno,c.ApellidoMaterno) as Cliente, 
IDTerapeuta, CONCAT_WS(' ',e.Nombre,e.ApellidoPaterno,e.ApellidoMaterno) as Terapeuta, ps.IDProductoServicio, ps.Producto, FechaCita,
con.IDHistorialMedico, cs.IDConsultaStatus, cs.Status, con.Observaciones
FROM Consulta con
inner join ConsultaStatus cs
on cs.IDConsultaStatus=con.IDConsultaStatus
inner join Cliente c
on c.IDCliente=con.IDCliente and c.Activo='S'
inner join Empleado e
on e.IDEmpleado=con.IDTerapeuta and e.Activo='S'
inner join ProductoServicio ps
on ps.IDProductoServicio=con.IDServicio;

CREATE VIEW V_Recepcion AS
SELECT IDRecepcion, rec.IDMovimientoAlmacen, Folio, p.IDProveedor, CONCAT_WS(' ',p.Nombre,p.ApellidoPaterno,p.ApellidoMaterno) as Proveedor,
e.IDEmpleado, CONCAT_WS(' ',e.Nombre,e.ApellidoPaterno,e.ApellidoMaterno) as Empleado, FechaRecepcion, Total
FROM Recepcion rec
inner join Proveedor p
on p.IDProveedor=rec.IDProveedor and p.Activo='S'
inner join MovimientoAlmacen ma
on ma.IDMovimientoAlmacen=rec.IDMovimientoAlmacen
inner join Empleado e
on e.IDEmpleado=ma.IDEmpleado and e.Activo='S';

CREATE VIEW V_Remision AS
SELECT IDRemision, rem.IDMovimientoAlmacen, Folio, c.IDCliente, CONCAT_WS(' ',c.Nombre,c.ApellidoPaterno,c.ApellidoMaterno) as Cliente,
e.IDEmpleado, CONCAT_WS(' ',e.Nombre,e.ApellidoPaterno,e.ApellidoMaterno) as Empleado, FechaRemision, Total
FROM Remision rem
inner join Cliente c
on c.IDCliente=rem.IDCliente and c.Activo='S'
inner join MovimientoAlmacen ma
on ma.IDMovimientoAlmacen=rem.IDMovimientoAlmacen
inner join Empleado e
on e.IDEmpleado=ma.IDEmpleado and e.Activo='S';

CREATE VIEW V_RemisionDetalle AS
SELECT IDRemisionDetalle, IDRemision, remd.IDProducto, ps.Producto, Cantidad, remd.PrecioUnitario, IVA, Descuento
FROM RemisionDetalle remd
inner join ProductoServicio ps
on ps.IDProductoServicio=remd.IDProducto;

CREATE VIEW V_RecepcionDetalle AS
SELECT IDRecepcionDetalle, IDRecepcion, recd.IDProducto, ps.Producto, Cantidad, recd.PrecioUnitario, IVA, Descuento
FROM RecepcionDetalle recd
inner join ProductoServicio ps
on ps.IDProductoServicio=recd.IDProducto;

CREATE VIEW V_AjusteEntradaDetalle AS
SELECT IDAjusteEntradaDetalle, IDAjusteEntrada, aed.IDProductoServicio, ps.Producto, Cantidad, aed.PrecioUnitario
FROM AjusteEntradaDetalle aed
inner join ProductoServicio ps
on ps.IDProductoServicio=aed.IDProductoServicio;

CREATE VIEW V_AjusteSalidaDetalle AS
SELECT IDAjusteSalidaDetalle, IDAjusteSalida, asd.IDProductoServicio, ps.Producto, Cantidad, asd.PrecioUnitario
FROM AjusteSalidaDetalle asd
inner join ProductoServicio ps
on ps.IDProductoServicio=asd.IDProductoServicio;

CREATE VIEW V_Existencia AS
SELECT IDExistencia, FechaReferencia, ex.IDProductoServicio, ps.Producto,
ex.PrecioUnitario, ex.Cantidad, ps.Activo
FROM Existencia ex
inner join ProductoServicio ps
on ps.IDProductoServicio=ex.IDProductoServicio;

CREATE VIEW V_HistorialMedico AS
SELECT IDHistorialMedico, hm.IDCliente, CONCAT_WS(' ',c.Nombre,c.ApellidoPaterno,c.ApellidoMaterno) as Cliente,
FechaRegistro, hm.IDServicio, ps.Producto, hm.Observaciones
FROM HistorialMedico hm
inner join Cliente c
on c.IDCliente=hm.IDCliente and c.Activo='S'
inner join ProductoServicio ps
on ps.IDProductoServicio=hm.IDServicio;

CREATE VIEW V_Producto AS
SELECT IDProductoServicio, ps.IDProductoServicioTipo, pst.ProductoServicioTipo,
Producto, PrecioUnitario, Foto, ps.Descripcion
FROM ProductoServicio ps
INNER JOIN ProductoServicioTipo pst
on pst.IDProductoServicioTipo=ps.IDProductoServicioTipo
WHERE ps.IDProductoServicioTipo=1 and ps.Activo='S';

CREATE VIEW V_Producto_Deleter AS
SELECT IDProductoServicio, ps.IDProductoServicioTipo, pst.ProductoServicioTipo,
Producto, PrecioUnitario, Foto, ps.Descripcion
FROM ProductoServicio ps
INNER JOIN ProductoServicioTipo pst
on pst.IDProductoServicioTipo=ps.IDProductoServicioTipo
WHERE ps.IDProductoServicioTipo=1 and ps.Activo='N';

CREATE VIEW V_Servicio AS
SELECT IDProductoServicio, ps.IDProductoServicioTipo, pst.ProductoServicioTipo,
Producto, PrecioUnitario, Foto, ps.Descripcion
FROM ProductoServicio ps
INNER JOIN ProductoServicioTipo pst
on pst.IDProductoServicioTipo=ps.IDProductoServicioTipo
WHERE ps.IDProductoServicioTipo=2 and ps.Activo='S';

CREATE VIEW V_Servicio_Deleter AS
SELECT IDProductoServicio, ps.IDProductoServicioTipo, pst.ProductoServicioTipo,
Producto, PrecioUnitario, Foto, ps.Descripcion
FROM ProductoServicio ps
INNER JOIN ProductoServicioTipo pst
on pst.IDProductoServicioTipo=ps.IDProductoServicioTipo
WHERE ps.IDProductoServicioTipo=2 and ps.Activo='N';

CREATE VIEW V_Proveedor AS
SELECT IDProveedor, Nombre, ApellidoPaterno, ApellidoMaterno, 
RFC, Calle, NumExterior, 
NumInterior, Colonia, CodigoPostal as CP, Email, Telefono, Celular 
From Proveedor p
WHERE p.Activo='S';

CREATE VIEW V_Proveedor_Deleter AS
SELECT IDProveedor, Nombre, ApellidoPaterno, ApellidoMaterno, 
RFC, Calle, NumExterior, 
NumInterior, Colonia, CodigoPostal as CP, Email, Telefono, Celular 
From Proveedor p
WHERE p.Activo='N';

CREATE VIEW V_Cliente AS
SELECT IDCliente, Nombre, ApellidoPaterno, ApellidoMaterno, 
Calle, NumExterior, 
NumInterior, Colonia, CodigoPostal as CP, Email, Telefono, Celular 
From Cliente c
WHERE c.Activo='S';

CREATE VIEW V_Cliente_Deleter AS
SELECT IDCliente, Nombre, ApellidoPaterno, ApellidoMaterno, 
Calle, NumExterior, 
NumInterior, Colonia, CodigoPostal as CP, Email, Telefono, Celular 
From Cliente c
WHERE c.Activo='N'; 

CREATE VIEW V_TotalVendido AS
SELECT ps.Producto,remd.PrecioUnitario,SUM(remd.Cantidad) as CantidadTotalVendida, DATE_FORMAT(ma.MovimientoAlmacenFecha,'%Y-%m-%d') as FechaVenta
from ProductoServicio as ps
inner join RemisionDetalle as remd
on remd.IDProducto = ps.IDProductoServicio
inner join Remision as rem
on rem.IDRemision = remd.IDRemision
inner join MovimientoAlmacen as ma
on ma.IDMovimientoAlmacen = rem.IDMovimientoAlmacen
GROUP BY ps.Producto,remd.PrecioUnitario,FechaVenta;

CREATE VIEW V_TotalComprado AS
SELECT ps.Producto,recd.PrecioUnitario,SUM(recd.Cantidad) as CantidadTotalComprada, DATE_FORMAT(ma.MovimientoAlmacenFecha,'%Y-%m-%d') as FechaCompra
from ProductoServicio as ps
inner join RecepcionDetalle as recd
on recd.IDProducto = ps.IDProductoServicio
inner join Recepcion as rec
on rec.IDRecepcion = recd.IDRecepcion
inner join MovimientoAlmacen as ma
on ma.IDMovimientoAlmacen = rec.IDMovimientoAlmacen
GROUP BY ps.Producto,recd.PrecioUnitario,FechaCompra;


/*

CREATE VIEW V_TotalEnAlmacen AS
SELECT ps.Producto,(SUM(recd.Cantidad) + SUM(aed.Cantidad) - SUM(remd.Cantidad) - SUM(asd.Cantidad)) as TotalEnAlmacen
FROM ProductoServicio as ps
inner join RecepcionDetalle as recd
on recd.IDProducto = ps.IDProductoServicio
inner join RemisionDetalle as remd
on remd.IDProducto = ps.IDProductoServicio
inner join AjusteSalidaDetalle as asd
on asd.IDProductoServicio = ps.IDProductoServicio
inner join AjusteEntradaDetalle as aed
on aed.IDProductoServicio = ps.IDProductoServicio
GROUP BY ps.Producto;


SELECT ps.Producto, SUM(recd.Cantidad) as TotalEnRecepcion
FROM ProductoServicio as ps
inner join RecepcionDetalle as recd
on recd.IDProducto = ps.IDProductoServicio
GROUP BY ps.Producto;

SELECT ps.Producto, SUM(remd.Cantidad) as TotalEnRemision
FROM ProductoServicio as ps
inner join RemisionDetalle as remd
on remd.IDProducto = ps.IDProductoServicio
GROUP BY ps.Producto;

*/