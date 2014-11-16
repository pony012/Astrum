<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Producto
	*/
class ProductoMdl extends BaseMdl{
	private $idProductoTipo;
	private $producto;
	private $precioUnitario;
	private $foto;
	private $descripcion;
	
	/**
	 *@param integer $idProductoTipo
	 *@param string $producto
	 *@param decimal $precioUnitario
	 *@param string $foto
	 *@param string $descripcion
	 *Crea un nuevo producto
	 *@return true
	 */
	function create($idProductoTipo, $producto, $precioUnitario, $foto = NULL, $descripcion = NULL){
		$this->idProductoTipo 	= $idProductoTipo;
		$this->producto			= $this->driver->real_escape_string($producto);
		$this->precioUnitario 	= $precioUnitario;
		$this->foto				= $this->driver->real_escape_string($foto);
		$this->descripcion		= $this->driver->real_escape_string($descripcion);
		
		$stmt = $this->driver->prepare("INSERT INTO ProductoServicio (IDProductoServicioTipo, Producto, PrecioUnitario, Foto, Descripcion) 
										VALUES(?,?,?,?,?)");
		if(!$stmt->bind_param('isdss',$this->idProductoTipo,$this->producto,$this->precioUnitario,$this->foto,$this->descripcion)){
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
	* Consulta los productos registrados y que esten activos
	*@param int $offset
	*@param int $idProducto
	* @return array or false
	**/
	function lists($offset = -1,$idProducto = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Producto LIMIT ?,?');
		}else{
			if($idProducto>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Producto WHERE IDProductoServicio=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Producto');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idProducto>-1){
				if(!$stmt->bind_param('i',$idProducto))
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
	* Consulta los productos registrados y que estan inactivos
	*@param int $offset
	*@param int $idProducto
	* @return array or false
	**/
	function listsDeleters($offset = -1,$idProducto = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Producto_Deleter LIMIT ?,?');
		}else{
			if($idProducto>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Producto_Deleter WHERE IDProductoServicio=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Producto_Deleter');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idProducto>-1){
				if(!$stmt->bind_param('i',$idProducto))
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
	*Da de baja a un determinado producto
	*@return true or false
	**/
	function delete($idProducto){
	
		if($stmt = $this->driver->prepare('SELECT Activo FROM ProductoServicio WHERE IDProductoServicio=? AND Activo = "S" AND IDProductoServicioTipo=1')){
		
			if(!$stmt->bind_param('i',$idProducto))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){
			
				//if($stmt = $this->driver->prepare('CALL desactivarProductoServicio(?)')){
				if($stmt = $this->driver->prepare('UPDATE ProductoServicio SET Activo="N" WHERE IDProductoServicio=? AND Activo = "S"')){
					if(!$stmt->bind_param('i',$idProducto))
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
	*Da Activa a un determinado producto que estuviera eliminado
	*@return true or false
	**/
	function active($idProducto){
		if($stmt = $this->driver->prepare('SELECT Activo FROM ProductoServicio WHERE IDProductoServicio=? AND Activo = "N" AND IDProductoServicioTipo=1')){
		
			if(!$stmt->bind_param('i',$idProducto))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){			
			
				//if($stmt = $this->driver->prepare('CALL activarProductoServicio(?)')){
				if($stmt = $this->driver->prepare('UPDATE ProductoServicio SET Activo="S" WHERE IDProductoServicio=? AND Activo = "N"')){
					if(!$stmt->bind_param('i',$idProducto))
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
	*Actualiza la información de un producto
	*@return true or false
	**/
	function update($idProducto,$idProductoTipo, $producto, $precioUnitario, $foto = NULL, $descripcion = NULL){
		if($stmt = $this->driver->prepare('SELECT IDProductoServicio FROM ProductoServicio WHERE IDProductoServicio=?')){
		
			if(!$stmt->bind_param('i',$idProducto))
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
				if(!$stmt->bind_param('isdssi',$this->idProductoTipo,$this->producto,$this->precioUnitario,$this->foto,$this->descripcion,$idProducto)){
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