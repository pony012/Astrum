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
	* Consulta todos los productos registrados
	* @return array or false
	**/
	function lists($constraint = '1 = 1'){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_Producto WHERE ?')){
		
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
	*Da de baja a un determinado producto
	*@return true or false
	**/
	function delete($idProducto){
	
		if($stmt = $this->driver->prepare('SELECT Activo FROM ProductoServicio WHERE IDProductoServicio=? AND Activo = "S"')){
		
			if(!$stmt->bind_param('i',$idProducto))
				die('Error Al Eliminar');
			
			if(!$stmt->execute())
				die('Error Al Eliminar');
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){
			
				if($stmt = $this->driver->prepare('CALL desactivarProductoServicio(?)')){
			
					if(!$stmt->bind_param('i',$idProducto))
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
	*Da Activa a un determinado producto que estuviera eliminado
	*@return true or false
	**/
	function active($idProducto){
		if($stmt = $this->driver->prepare('SELECT Activo FROM ProductoServicio WHERE IDProductoServicio=? AND Activo = "N"')){
		
			if(!$stmt->bind_param('i',$idProducto))
				die('Error Al Activar');
			
			if(!$stmt->execute())
				die('Error Al Activar');
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){			
			
				if($stmt = $this->driver->prepare('CALL activarProductoServicio(?)')){
			
					if(!$stmt->bind_param('i',$idProducto))
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

	/**
	*Actualiza la información de un producto
	*@return true or false
	**/
	function update($idProducto,$idProductoTipo, $producto, $precioUnitario, $foto = NULL, $descripcion = NULL){
		if($stmt = $this->driver->prepare('SELECT IDProductoServicio FROM ProductoServicio WHERE IDProductoServicio=?')){
		
			if(!$stmt->bind_param('i',$idProducto))
				die('Error Al Actualizar');
			
			if(!$stmt->execute())
				die('Error Al Actualizar');
				
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
					die('Error al Actualizar en la base de datos');
				}
				if (!$stmt->execute()) {
					die('Error al Actualizar en la base de datos');
				}

				if($this->driver->error){
					return false;
				}

				return true;
			}
		}
		else
			die('Error al Actualizar en la base de datos');
	}

}
?>