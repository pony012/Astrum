CREATE TABLE EmpleadoSueldo(
    IDEmpleadoSueldo INT PRIMARY KEY AUTO_INCREMENT,
    IDEmpleado INT NOT NULL,
    FechaSueldo DATE NOT NULL,
    Sueldo DECIMAL(10,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (IDEmpleado) REFERENCES Empleado(IDEmpleado)
);