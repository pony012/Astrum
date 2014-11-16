<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de los tipos Movimientos de Almacén
	*/
class MovimientoAlmacenTipoMdl extends BaseMdl{
	private $tipoMovimientoAlmacen;
	private $entradaSalida;
	private $descripcion;
	
	/**
	 *@param string $tipoMovimientoAlmacen
	 *@param string $entradaSalida
	 *@param string $descripcion
	 *Crea un nuevo tipo de movimiento de almacen
	 *@return true
	 */
	function create($tipoMovimientoAlmacen,$entradaSalida,$descripcion){
		$this->tipoMovimientoAlmacen 	= $this->driver->real_escape_string($tipoMovimientoAlmacen);
		$this->entradaSalida			= $this->driver->real_escape_string($entradaSalida);
		$this->descripcion				= $this->driver->real_escape_string($descripcion);
		
		$stmt = $this->driver->prepare("INSERT INTO 
										MovimientoAlmacenTipo (TipoMovimientoAlmacen,EntradaSalida,Descripcion)
										VALUES(?,?,?)");
		if(!$stmt->bind_param('sss',$this->tipoMovimientoAlmacen,$this->entradaSalida,$this->descripcion)){
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
	*Actualiza la información de un tipo de movimiento de Almacén
	*@param int $idMovimientoAlmacenTipo
	*@param string $tipoMovimientoAlmacen
	*@param string $entradaSalida
	*@param string $descripcion
	*@return true or false
	**/
	function update($idMovimientoAlmacenTipo,$tipoMovimientoAlmacen,$entradaSalida,$descripcion){
		if($stmt = $this->driver->prepare('SELECT IDMovimientoAlmacenTipo FROM MovimientoAlmacenTipo WHERE IDMovimientoAlmacenTipo=?')){
		
			if(!$stmt->bind_param('i',$idMovimientoAlmacenTipo))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDMovimientoAlmacenTipo']!=''){
				$this->tipoMovimientoAlmacen 	= $this->driver->real_escape_string($tipoMovimientoAlmacen);
				$this->entradaSalida			= $this->driver->real_escape_string($entradaSalida);
				$this->descripcion				= $this->driver->real_escape_string($descripcion);
				
				$stmt = $this->driver->prepare("UPDATE MovimientoAlmacenTipo SET TipoMovimientoAlmacen=?,EntradaSalida=?,Descripcion=? WHERE IDMovimientoAlmacenTipo=?");
				if(!$stmt->bind_param('sssi',$this->tipoMovimientoAlmacen,$this->entradaSalida,$this->descripcion,$idMovimientoAlmacenTipo)){
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

	/**
	* Consulta a los tipos de movimientos de Almacén registrados
	*@param int $offset
	*@param int $idMovimientoAlmacenTipo
	*@param string $constrain
	* @return array or false
	**/
	function lists($offset = -1,$idMovimientoAlmacenTipo = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM MovimientoAlmacenTipo WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idMovimientoAlmacenTipo>-1){
				$stmt = $this->driver->prepare('SELECT * FROM MovimientoAlmacenTipo WHERE IDMovimientoAlmacenTipo=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM MovimientoAlmacenTipo WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idMovimientoAlmacenTipo>-1){
				if(!$stmt->bind_param('i',$idMovimientoAlmacenTipo))
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
}
?>
