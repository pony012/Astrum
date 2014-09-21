Astrum
=========

Proyecto para la clase de Programación Web (CC419)

Los integrantes del equipo somos

  - [Alan Andrés Sánchez Castro]
  - [Ramón Lozano Franco]
  - [Christian Abimael Velázquez Pérez]

Descipción del proyecto
----
Spa Damaris es un spa que tiene ya años en el mercado satisfaciendo la necesidades de sus clientes, pero su forma de administración no es óptima, las citas de los clientes se hacen a papel, se tiene un historial clínico de sus clientes en archivos de office y corren el riesgo de perder valiosa información por no tener guardada su información en una base de datos en la nube. No tienen un inventario de sus productos ni registro de las ventas que realizan, y los cortes de sueldos al final de la quincena se vuelven lentos y laboriosos porque cada terapeuta hace su reporte, por lo mismo no se sabe si el reporte de salario de cada terapeuta es verídico, puesto que no se lleva un buen control.

Version
----

0.1

URL del proyecto y parámetros
--------------

http://astrum.x10.mx

Para elegir el módulo a utilizar, se usa la variable enviada por ```GET```
    
    $_GET['ctrl']

y para elegir la acción a realizar (actualmente sólo ```create```)

    $_GET['act']
    
Ejemplo: http://astrum.x10.mx/?ctrl=empleado&act=create

Módulos y parámetros
-----------

Los datos que se enviarán a los módulos será por medio de ```POST```, y se explicarán a continuación.

```Date``` es un ```String``` con el formato ```YYYY-MM-DD```.

```Phone``` es un ```String``` con el formato ```^(\+\d{1,4}[- ])?(\d+([ -])*)+$```.

```Name``` es un ```String``` .

```List``` es una lista de *checkboxes* o *radiobuttons*, por el momento no es necesario mandar esos parámetros.


El proyecto actualmente cuenta con 10 módulos, y la única acción que puede ser realizada es crear:

  - [ajusteEntrada]
   -  *Int* ```idAjusteEntradaTipo ```
   -  *Int* ```idCliente ```
   -  *Int* ```folio```
   - *String* ```observaciones```
   - **List* ```idProductoServicios ``` 
   - **List* ```cantidades```
  - [ajusteSalida]
   -  *Int* ```idAjusteSalidaTipo ```
   -  *Int* ```idCliente ```
   -  *Int* ```folio```
   - *String* ```observaciones```
   - **List* ```idProductoServicios ``` 
   - **List* ```cantidades```
  - [consulta]
   - *Int* ```idCliente ```
   - *Int* ```idTerapeuta ```
   - *Int* ```idHistorialMedico```
   - *Date* ```fechaCita ```
   - *Int* ```idConsultaStatus ```
   - *String* ```observaciones```
  - [empleado]
   - *Name* ```nombre ```
   - *Name*  ```apellidoPaterno ```
   - *Name*  ```apellidoMaterno```
   - *String* ```usuario```
   - *String* ```contrasena```
   - *Int* ```idCargo```
   - *String* ```calle```
   - *String* ```numExterior```
   - *String* ```numInterior```
   - *String* ```colonia```
   - *Int* ```codigoPostal```
   - *String* ```foto```
   - *Email* ```email```
   - *Phone* ```telefono```
   - *Phone* ```celular```
  - [historialMedico]
   - *Int* ```pesoIni  ```
   - *Int*  ```bustoIni  ```
   - *Int*  ```diafragmaIni  ```
   - *Int*  ```brazoIni  ```
   - *Int*  ```cinturaIni          ```
   - *Int*  ```abdomenIni  ```
   - *Int*  ```caderaIni  ```
   - *Int*  ```musloIni  ```
   - *Int*  ```pesoFin  ```
   - *Int*  ```bustoFin  ```
   - *Int*  ```diafragmaFin  ```
   - *Int*  ```brazoFin  ```
   - *Int*  ```cinturaFin  ```
   - *Int*  ```abdomenFin  ```
   - *Int*  ```caderaFin  ```
   - *Int*  ```musloFin    ```
   - *String* ```motivoConsulta  ```
   - *String* ```tiempoProblema  ```
   - *String* ```relacionaCon     ```
   - *String* ```tratamientoAnterior ```
   - *String* ```metProbados  ```
   - *String* ```resAnteriores  ```
   - *Int*  ```idCliente  ```
   - *Date* ```fechaRegistro  ```
   - *Int*  ```idServicio  ```
   - *String* ```observaciones  ```
   - *String* ```estadoAguaAlDia  ```
   - *String* ```estadoAlimentacion  ```
   - **List* ```arregloExfolacion   ```
   - **List* ```arregloHabito  ```
   - **List* ```arregloPadecimiento ```
   - **List* ```arregloPiel  ```
   - **List* ```arregloTipoCelulitis```
  - [producto]
   - *Int* ```idProductoTipo```
   - *String* ```producto  ```
   - *Int*  ```precioUnitario```
   - *String* ```foto  ```
   - *String* ```descripcion ```
  - [proveedor]
   - *Name* ```nombre  ```
   - *Name*  ```apellidoPaterno ```
   - *Name*  ```apellidoMaterno```
   - *String* ```RFC ```
   - *String* ```calle ```
   - *String* ```numExterior ```
   - *String* ```numInterior ```
   - *String* ```colonia ```
   - *Int* ```codigoPostal ```
   - *String* ```foto ```
   - *Email* ```email ```
   - *Phone* ```telefono ```
   - *Phone* ```celular ```
  - [recepcion]
   - *Int* ```idProveedor```
   - *Int*  ```folio ```
   - *Date* ```fechaRecepcion```
   - **List* ```idProductos ```
   - **List* ```cantidades ```
   - **List* ```precioUnitario```
   - **List* ```ivas  ```
   - **List* ```descuentos ```
  - [remision]
   - *Int*  ```idCliente```
   - *Int*  ```folio```
   - *Date*  ```fechaRemision```
   - **List* ```idProductos ```
   - **List* ```cantidades```
   - **List* ```precioUnitario```
   - **List* ```ivas ```
   - **List* ```descuentos ```
  - [servicio]
   - *Int* ```idServicioTipo```
   - *String* ```servicio  ```
   - *Int*  ```precioUnitario```
   - *String* ```foto  ```
   - *String* ```descripcion ```

License
----

MIT


**Free Software, Hell Yeah!**
[Alan Andrés Sánchez Castro]:http://github.com/pony012
[Ramón Lozano Franco]:http://github.com/rmn528
[Christian Abimael Velázquez Pérez]:http://github.com/abimael93
[ajusteEntrada]:http://astrum.x10.mx/?ctrl=ajusteEntrada&act=create
[ajusteSalida]:http://astrum.x10.mx/?ctrl=ajusteSalida&act=create
[consulta]:http://astrum.x10.mx/?ctrl=consulta&act=create
[empleado]:http://astrum.x10.mx/?ctrl=empleado&act=create
[historialMedico]:http://astrum.x10.mx/?ctrl=historialMedico&act=create
[producto]:http://astrum.x10.mx/?ctrl=producto&act=create
[proveedor]:http://astrum.x10.mx/?ctrl=proveedor&act=create
[recepcion]:http://astrum.x10.mx/?ctrl=recepcion&act=create
[remision]:http://astrum.x10.mx/?ctrl=remision&act=create
[servicio]:http://astrum.x10.mx/?ctrl=servicio&act=create
