DELIMITER |
CREATE PROCEDURE desactivarEmpleado(IN ID INT)
BEGIN
	UPDATE Empleado SET Activo="N" WHERE IDEmpleado=ID;
END;

DELIMITER |
CREATE PROCEDURE activarEmpleado(IN ID INT)
BEGIN
	UPDATE Empleado SET Activo="S" WHERE IDEmpleado=ID;
END;

DELIMITER |
CREATE PROCEDURE desactivarCliente(IN ID INT)
BEGIN
	UPDATE Cliente SET Activo="N" WHERE IDCliente=ID;
END;

DELIMITER |
CREATE PROCEDURE activarCliente(IN ID INT)
BEGIN
	UPDATE Cliente SET Activo="S" WHERE IDCliente=ID;
END;

DELIMITER |
CREATE PROCEDURE desactivarProveedor(IN ID INT)
BEGIN
	UPDATE Proveedor SET Activo="N" WHERE IDProveedor=ID;
END;

DELIMITER |
CREATE PROCEDURE activarProveedor(IN ID INT)
BEGIN
	UPDATE Proveedor SET Activo="S" WHERE IDProveedor=ID;
END;

DELIMITER |
CREATE PROCEDURE desactivarProductoServicio(IN ID INT)
BEGIN
	UPDATE ProductoServicio SET Activo="N" WHERE IDProductoServicio=ID;
END;

DELIMITER |
CREATE PROCEDURE activarProductoServicio(IN ID INT)
BEGIN
	UPDATE ProductoServicio SET Activo="S" WHERE IDProductoServicio=ID;
END;