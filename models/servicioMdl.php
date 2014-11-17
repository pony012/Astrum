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
	function create($servicio, $precioUnitario, $foto = NULL, $descripcion = NULL){
		$this->idServicioTipo 	= $idServicioTipo;
		$this->servicio			= $this->driver->real_escape_string($servicio);
		$this->precioUnitario	= $precioUnitario;
		$this->foto				= $this->driver->real_escape_string($foto);
		$this->descripcion		= $this->driver->real_escape_string($descripcion);
		
		$stmt = $this->driver->prepare("INSERT INTO ProductoServicio (Producto, PrecioUnitario, Foto, Descripcion) 
										VALUES(2,?,?,?,?)");
		if(!$stmt->bind_param('sdss'$this->servicio,$this->precioUnitario,$this->foto,$this->descripcion)){
			return false;
		}
		if (!$stmt->execute()) {
			return false;
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}
	
	/**
	* Consulta los servicios registrados y que esten activos
	*@param int $offset
	*@param int $idServicio
	* @return array or false
	**/
	function lists($offset = -1,$idServicio = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Servicio WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idServicio>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Servicio WHERE IDProductoServicio=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Servicio WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idServicio>-1){
				if(!$stmt->bind_param('i',$idServicio))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}

	/**
	* Consulta los servicios registrados y que estan inactivos
	*@param int $offset
	*@param int $idServicio
	* @return array or false
	**/
	function listsDeleters($offset = -1,$idServicio = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Servicio_Deleter LIMIT ?,?');
		}else{
			if($idServicio>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Servicio_Deleter WHERE IDProductoServicio=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Servicio_Deleter');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idServicio>-1){
				if(!$stmt->bind_param('i',$idServicio))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}
	
	/**
	*Da de baja a un determinado servicio
	*@return true or false
	**/
	function delete($idServicio){
	
		if($stmt = $this->driver->prepare('SELECT Activo FROM ProductoServicio WHERE IDProductoServicio=? AND Activo = "S" AND IDProductoServicioTipo=2')){
		
			if(!$stmt->bind_param('i',$idServicio))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){
			
				//if($stmt = $this->driver->prepare('CALL desactivarProductoServicio(?)')){
				if($stmt = $this->driver->prepare('UPDATE ProductoServicio SET Activo="N" WHERE IDProductoServicio=? AND Activo = "S" AND IDProductoServicioTipo=2')){
			
					if(!$stmt->bind_param('i',$idServicio))
						return false;
					
					if(!$stmt->execute())
						return false;
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
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){			
			
				//if($stmt = $this->driver->prepare('CALL activarProductoServicio(?)')){
				if($stmt = $this->driver->prepare('UPDATE ProductoServicio SET Activo="S" WHERE IDProductoServicio=? AND Activo = "N"')){
			
					if(!$stmt->bind_param('i',$idServicio))
						return false;
					
					if(!$stmt->execute())
						return false;
					else
						return true;
				}
			}
		}

		return false;
	}

	/**
	*Actualiza la información de un servicio
	*@return true or false
	**/
	function update($idServicio,$idProductoTipo, $producto, $precioUnitario, $foto = NULL, $descripcion = NULL){
		if($stmt = $this->driver->prepare('SELECT IDProductoServicio FROM ProductoServicio WHERE IDProductoServicio=?')){
		
			if(!$stmt->bind_param('i',$idServicio))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDProductoServicio']!=''){
				$this->idProductoTipo 	= $idProductoTipo;
				$this->producto			= $this->driver->real_escape_string($producto);
				$this->precioUnitario 	= $precioUnitario;
				$this->foto				= $this->driver->real_escape_string($foto);
				$this->descripcion		= $this->driver->real_escape_string($descripcion);
				
				$stmt = $this->driver->prepare("UPDATE ProductoServicio SET IDProductoServicioTipo=?, Producto=?, PrecioUnitario=?, Foto=?, Descripcion=? 
												WHERE IDProductoServicio=?");
				if(!$stmt->bind_param('isdssi',$this->idProductoTipo,$this->producto,$this->precioUnitario,$this->foto,$this->descripcion,$idServicio)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}
}
?>