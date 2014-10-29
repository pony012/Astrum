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

0.3

Changelog
----
0.1

- Creación del Proyecto
- Creación del esqueleto MVC
- Creación de los Modelos y Controladores Base
- Creación de la acción ```create```
- Craeción de algunas vistas
- Creación del index

0.2

- Modificación del index
- Creación de la Base de Datos
- ABC de la base de datos (acciones básicas)
- Se comenzó con el proceso de login
- Creación de las acciones ```delete```, ```lists``` y  ```update``` y modificación de ```create```

0.3
- Creación del sistema de permisos (login)
  - Las credenciales de prueba son
    - ```User```: ```admin```
    - ```Pass```: ```astrum1234```
  - Los cargos de los usuarios son:
    - ```Admin```
    - ```Terapeuta```
    - ```Empleado```
- Mailing cuando se da de alta un usuario

URL del proyecto y parámetros
--------------

http://astrumcucei.com

Para elegir el módulo a utilizar, se usa la variable enviada por ```GET```
    
    $_GET['ctrl']

y para elegir la acción a realizar (las posibles son ```create```, ```delete```, ```lists``` y  ```update```)

    $_GET['act']
    
Ejemplo: http://astrumcucei.com/?ctrl=empleado&act=create

Módulos y parámetros
-----------

Los datos que se enviarán a los módulos será por medio de ```POST```, y se explicarán a continuación.

```Date``` es un ```String``` con el formato ```YYYY-MM-DD```.

```Phone``` es un ```String``` con el formato ```^(\+\d{1,4}[- ])?(\d+([ -])*)+$```.

```Name``` es un ```String``` .

```List``` es una lista de *checkboxes* o *radiobuttons*, por el momento no es necesario mandar esos parámetros.


El proyecto actualmente cuenta con 11 módulos.

Los enlaces aquí mostrados sólo llaman al controlador, falta decirles qué acción hacer.

En caso de llamarse con la acción de ```update```, además de los parámetros de su respectivo  ```create```, tendrá que mandarse un *Int* con el id del elemento a modificar, en caso de llamarse con la acción de ```delete```, sólo bastará con el parámetro antes mencionado. El nombre del parámetro será id*Modulo*, por ejemplo:
    
    //Para modificar o eliminar el cliente con id 2
    $_POST['idCliente'] = 2;
    //Para modificar o eliminar el proveedor con id 10
    $_POST['idProveedor'] = 10;

Los módulos en los que se puede llamar a ```update``` o ```delete``` son:
 
 - [empleado]
 - [proveedor]
 - [cliente]
 - [producto]
 - [servicio]

En caso de llamarse con la ación de ```create``` los parámetros serán los siguientes (A estos mismos modulos podrán hacerse ```lists```, sólo que para esta acción no es necesario mandarle parámetros, en un futuro podrán filtrarse por *id* o por algún otro parámetro):

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
  - [cliente]
    - *Name* ```nombre    ```
    - *Name* ```apellidoPaterno```
    - *Name* ```apellidoMaterno```
    - *String* ```calle    ```
    - *String* ```numExterior```
    - *String* ```numInterior```
    - *String* ```colonia  ```
    - *Int* ```codigoPostal```
    - *Email* ```email```
    - *Phone* ```telefono ```
    - *Phone* ```celular  ```
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
[ajusteEntrada]:http://astrumcucei.com/?ctrl=ajusteEntrada
[ajusteSalida]:http://astrumcucei.com/?ctrl=ajusteSalida
[consulta]:http://astrumcucei.com/?ctrl=consulta
[cliente]:http://astrumcucei.com/?ctrl=cliente
[empleado]:http://astrumcucei.com/?ctrl=empleado
[historialMedico]:http://astrumcucei.com/?ctrl=historialMedico
[producto]:http://astrumcucei.com/?ctrl=producto
[proveedor]:http://astrumcucei.com/?ctrl=proveedor
[recepcion]:http://astrumcucei.com/?ctrl=recepcion
[remision]:http://astrumcucei.com/?ctrl=remision
[servicio]:http://astrumcucei.com/?ctrl=servicio
