<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Servicio
	*/
class ServicioMdl extends BaseMdl{
	private $idServicioTipo;
	private $servicio;
	private $precioUnitario;
	private $foto;
	private $descripcion;
	
	/**
	 *@param integer $idServicioTipo
	 *@param string $servicio
	 *@param decimal $precioUnitario
	 *@param string $foto
	 *@param string $descripcion
	 *Crea un nuevo servicio
	 *@return true
	 */
	function create($idServicioTipo, $servicio, $precioUnitario, $foto = NULL, $descripcion = NULL){
		$this->idServicioTipo 	= $idServicioTipo;
		$this->servicio			= $this->driver->real_escape_string($servicio);
		$this->precioUnitario	= $precioUnitario;
		$this->foto				= $this->driver->real_escape_string($foto);
		$this->descripcion		= $this->driver->real_escape_string($descripcion);
		
		$stmt = $this->driver->prepare("INSERT INTO ProductoServicio (IDProductoServicioTipo, Producto, PrecioUnitario, Foto, Descripcion) 
										VALUES(?,?,?,?,?)");
		if(!$stmt->bind_param('isdss',$this->idProductoTipo,$this->servicio,$this->precioUnitario,$this->foto,$this->descripcion)){
			die('Error al insertar en la base de datos');
		}
		if (!$stmt->execute()) {
			die('Error al insertar en la base de datos');
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}
	
	/**
	* Consulta todos los servicios registrados
	* @return array or false
	**/
	function lists($constraint = '1 = 1'){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_Servicio WHERE ?')){
		
			if(!$stmt->bind_param('s',$constraint))
				die('Error Al Consultar');

			if(!$stmt->execute())
				die('Error Al Consultar');

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);

				return $rows;
			}else
				die('No hay Resultados!!!');

		}else
			die('Error Al Consultar');
			
		return false;
	}
	
	/**
	*Da de baja a un determinado servicio
	*@return true or false
	**/
	function delete($idServicio){
	
		if($stmt = $this->driver->prepare('SELECT Activo FROM ProductoServicio WHERE IDProductoServicio=? AND Activo = "S"')){
		
			if(!$stmt->bind_param('i',$idServicio))
				die('Error Al Eliminar');
			
			if(!$stmt->execute())
				die('Error Al Eliminar');
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){
			
				if($stmt = $this->driver->prepare('CALL desactivarProductoServicio(?)')){
			
					if(!$stmt->bind_param('i',$idServicio))
						die('Error Al Eliminar');
					
					if(!$stmt->execute())
						die('Error Al Eliminar');
					else
						return true;
				}
			}
		}

		return false;
	}

	/**
	*Da Activa a un determinado servicio que estuviera eliminado
	*@return true or false
	**/
	function active($idServicio){
		if($stmt = $this->driver->prepare('SELECT Activo FROM ProductoServicio WHERE IDProductoServicio=? AND Activo = "N"')){
		
			if(!$stmt->bind_param('i',$idServicio))
				die('Error Al Activar');
			
			if(!$stmt->execute())
				die('Error Al Activar');
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){			
			
				if($stmt = $this->driver->prepare('CALL activarProductoServicio(?)')){
			
					if(!$stmt->bind_param('i',$idServicio))
						die('Error Al Activar');
					
					if(!$stmt->execute())
						die('Error Al Activar');
					else
						return true;
				}
			}
		}

		return false;
	}
}
?>