CREATE VIEW V_Empleado AS
SELECT IDEmpleado, Nombre, ApellidoPaterno as "Apellido Paterno", ApellidoMaterno as "Apellido Materno", 
Usuario, Contrasena as "Contraseña", c.Cargo as Cargo, Calle, NumExterior as "Numero Exterior", 
NumInterior as "Numero Interior", Colonia, CodigoPostal as CP, Foto, Email, Telefono, Celular 
From Empleado e 
inner join Cargo c 
on c.IDCargo=e.IDCargo and e.Activo='S'; 

CREATE VIEW V_AjusteEntrada AS
SELECT IDAjusteEntrada, ae.IDMovimientoAlmacen, Folio, aet.Tipo, c.IDCliente, (c.Nombre + c.ApellidoPaterno + c.ApellidoMaterno) as Cliente, e.IDEmpleado, (e.Nombre + e.ApellidoPaterno + e.ApellidoMaterno) as Empleado, Observaciones
From AjusteEntrada ae
inner join AjusteEntradaTipo aet
on aet.IDAjusteEntradaTipo=ae.IDAjusteEntradaTipo
inner join Cliente c
on c.IDCliente=ae.IDCliente and c.Activo='S'
inner join MovimientoAlmacen ma
on ma.IDMovimientoAlmacen=ae.IDMovimientoAlmacen
inner join Empleado e
on ma.IDEmpleado=e.IDEmpleado and e.Activo='S';

CREATE VIEW V_AjusteSalida AS
SELECT IDAjusteSalida, ae.IDMovimientoAlmacen, Folio, aet.Tipo, p.IDProveedor, (p.Nombre + p.ApellidoPaterno + p.ApellidoMaterno) as Proveedor, e.IDEmpleado, (e.Nombre + e.ApellidoPaterno + e.ApellidoMaterno) as Empleado, Observaciones
From AjusteSalida ae
inner join AjusteSalidaTipo aet
on aet.IDAjusteSalidaTipo=ae.IDAjusteSalidaTipo
inner join Proveedor p
on p.IDProveedor=ae.IDProveedor and p.Activo='S'
inner join MovimientoAlmacen ma
on ma.IDMovimientoAlmacen=ae.IDMovimientoAlmacen
inner join Empleado e
on ma.IDEmpleado=e.IDEmpleado and e.Activo='S';

CREATE VIEW V_Consulta AS
SELECT IDConsulta, con.IDCliente, (c.Nombre + c.ApellidoPaterno + c.ApellidoMaterno) as Cliente, 
IDTerapeuta, (e.Nombre + e.ApellidoPaterno + e.ApellidoMaterno) as Terapeuta, ps.IDProductoServicio, ps.Producto, FechaCita as "Fecha de la Cita",
con.IDHistorialMedico, cs.Status, con.Observaciones
FROM Consulta con
inner join ConsultaStatus cs
on cs.IDConsultaStatus=con.IDConsultaStatus
inner join Cliente c
on c.IDCliente=con.IDCliente and c.Activo='S'
inner join Empleado e
on e.IDEmpleado=con.IDTerapeuta and e.Activo='S'
inner join HistorialMedico hm
on hm.IDHistorialMedico=con.IDHistorialMedico
inner join ProductoServicio ps
on ps.IDProductoServicio=hm.IDServicio and ps.Activo='S';

CREATE VIEW V_ProductoServicio AS
SELECT IDProductoServicio, Producto, pst.ProductoServicioTipo, PrecioUnitario,
Foto, ps.Descripcion
From ProductoServicio ps
inner join ProductoServicioTipo pst
on pst.IDProductoServicioTipo=ps.IDProductoServicioTipo and ps.Activo='S';

CREATE VIEW V_Recepcion AS
SELECT IDRecepcion, rec.IDMovimientoAlmacen, Folio, p.IDProveedor, (p.Nombre + p.ApellidoPaterno + p.ApellidoMaterno) as Proveedor,
e.IDEmpleado, (e.Nombre + e.ApellidoPaterno + e.ApellidoMaterno) as Empleado, FechaRecepcion as "Fecha de Recepcion", Total
FROM Recepcion rec
inner join Proveedor p
on p.IDProveedor=rec.IDProveedor and p.Activo='S'
inner join MovimientoAlmacen ma
on ma.IDMovimientoAlmacen=rec.IDMovimientoAlmacen
inner join Empleado e
on e.IDEmpleado=ma.IDEmpleado and e.Activo='S';

CREATE VIEW V_Remision AS
SELECT IDRemision, rem.IDMovimientoAlmacen, Folio, c.IDCliente, (c.Nombre + c.ApellidoPaterno + c.ApellidoMaterno) as Cliente,
e.IDEmpleado, (e.Nombre + e.ApellidoPaterno + e.ApellidoMaterno) as Empleado, FechaRemision as "Fecha de Remision", Total
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
on ps.IDProductoServicioTipo=remd.IDProducto and ps.Activo='S';

CREATE VIEW V_RecepcionDetalle AS
SELECT IDRecepcionDetalle, IDRecepcion, recd.IDProducto, ps.Producto, Cantidad, recd.PrecioUnitario, IVA, Descuento
FROM RecepcionDetalle recd
inner join ProductoServicio ps
on ps.IDProductoServicioTipo=recd.IDProducto and ps.Activo='S';

CREATE VIEW V_AjusteEntradaDetalle AS
SELECT IDAjusteEntradaDetalle, IDAjusteEntrada, aed.IDProductoServicio, ps.Producto, Cantidad
FROM AjusteEntradaDetalle aed
inner join ProductoServicio ps
on ps.IDProductoServicio=aed.IDProductoServicio and ps.Activo='S';

CREATE VIEW V_AjusteSalidaDetalle AS
SELECT IDAjusteSalidaDetalle, IDAjusteSalida, asd.IDProductoServicio, ps.Producto, Cantidad
FROM AjusteSalidaDetalle asd
inner join ProductoServicio ps
on ps.IDProductoServicio=asd.IDProductoServicio and ps.Activo='S';

CREATE VIEW V_Existencia AS
SELECT IDExistencia, FechaReferencia as "Fecha de Referencia", ex.IDProductoServicio, ps.Producto,
ex.PrecioUnitario, ex.Cantidad
FROM Existencia ex
inner join ProductoServicio ps
on ps.IDProductoServicio=ex.IDProductoServicio and ps.Activo='S';

CREATE VIEW V_HistorialMedico AS
SELECT IDHistorialMedico, hm.IDCliente, (c.Nombre + c.ApellidoPaterno + c.ApellidoMaterno) as Cliente,
FechaRegistro as "Fecha de Registro", hm.IDServicio, ps.Producto, hm.Observaciones
FROM HistorialMedico hm
inner join Cliente c
on c.IDCliente=hm.IDCliente and c.Activo='S'
inner join ProductoServicio ps
on ps.IDProductoServicio=hm.IDServicio and ps.Activo='S';