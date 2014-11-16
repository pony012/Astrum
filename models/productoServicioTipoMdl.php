<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de los tipos Movimientos de Almacén
	*/
class ProductoServicioTipoMdl extends BaseMdl{
	private $productoServicioTipo;
	private $descripcion;
	
	/**
	 *@param string $productoServicioTipo
	 *@param string $descripcion
	 *Crea un nuevo tipo de movimiento de almacen
	 *@return true
	 */
	function create($productoServicioTipo,$descripcion){
		$this->productoServicioTipo 	= $this->driver->real_escape_string($productoServicioTipo);
		$this->descripcion				= $this->driver->real_escape_string($descripcion);
		
		$stmt = $this->driver->prepare("INSERT INTO 
										ProductoServicioTipo (ProductoServicioTipo,Descripcion)
										VALUES(?,?)");
		if(!$stmt->bind_param('ss',$this->productoServicioTipo,$this->descripcion)){
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
	*@param int $idProductoServicioTipo
	*@param string $productoServicioTipo
	*@param string $descripcion
	*@return true or false
	**/
	function update($idProductoServicioTipo,$productoServicioTipo,$descripcion){
		if($stmt = $this->driver->prepare('SELECT IDProductoServicioTipo FROM ProductoServicioTipo WHERE IDProductoServicioTipo=?')){
		
			if(!$stmt->bind_param('i',$idProductoServicioTipo))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDProductoServicioTipo']!=''){
				$this->productoServicioTipo 	= $this->driver->real_escape_string($productoServicioTipo);
				$this->descripcion				= $this->driver->real_escape_string($descripcion);
				
				$stmt = $this->driver->prepare("UPDATE ProductoServicioTipo SET ProductoServicioTipo=?,Descripcion=? WHERE IDProductoServicioTipo=?");
				if(!$stmt->bind_param('ssi',$this->productoServicioTipo,$this->descripcion,$idProductoServicioTipo)){
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
	*@param int $idProductoServicioTipo
	*@param string $constrain
	* @return array or false
	**/
	function lists($offset = -1,$idProductoServicioTipo = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM ProductoServicioTipo WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idProductoServicioTipo>-1){
				$stmt = $this->driver->prepare('SELECT * FROM ProductoServicioTipo WHERE IDProductoServicioTipo=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM ProductoServicioTipo WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idProductoServicioTipo>-1){
				if(!$stmt->bind_param('i',$idProductoServicioTipo))
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
