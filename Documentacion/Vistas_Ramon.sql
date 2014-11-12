CREATE VIEW V_Cliente_Deleter AS
SELECT IDCliente, Nombre, ApellidoPaterno, ApellidoMaterno, 
Calle, NumExterior, 
NumInterior, Colonia, CodigoPostal as CP, Email, Telefono, Celular 
From Cliente c
WHERE c.Activo='N'; 