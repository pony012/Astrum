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
		$this->idProductoTipo = $idProductoTipo;
		$this->producto	= $producto;
		$this->precioUnitario	= $precioUnitario;
		$this->foto	= $foto;
		$this->descripcion	= $descripcion;
		
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
}
?>